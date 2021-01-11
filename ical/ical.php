<?php declare(strict_types=1);

require_once('icalEvent.php');

class iCal
{
    public $Events = array();

    public function __construct(string $content)
    {
        $isUrl = strpos($content, 'http') === 0 && filter_var($content, FILTER_VALIDATE_URL);
        $isFile = strpos($content, "\n") === false && file_exists($content);

        if ($isUrl || $isFile)
        {
            $this->parse(file_get_contents($content));
        }
    }

    protected function parse(string $content) : iCal
    {
        $content = str_replace("\r\n ", '', $content);

        preg_match_all('`BEGIN:VEVENT(.+)END:VEVENT`Us', $content, $matches);
        foreach($matches[0] as $eventContent)
        {
            $this->Events[] = new iCalEvent($eventContent);
        }

        return $this;
    }

    public function getEventsAfterDate(string $date) : array
    {
        $output = array();

        $date = strtotime($date);
        foreach ($this->Events as $event) 
        {
            $eventTimestamp = strtotime($event->startDateTime);
            if ($eventTimestamp >= $date)
            {
                $output[] = $event;
            }
        }

        asort($output);
        return $output;
    }

    public function getActiveEvents() : array
    {
        $output = array();

        $currentDate = strtotime(date('Y-m-d'));
        foreach ($this->Events as $event)
        {
            $eventStartTimestamp = strtotime($event->startDateTime);
            $eventEndTimestamp = strtotime($event->endDateTime);
            if ($currentDate >= $eventStartTimestamp && $currentDate <= $eventEndTimestamp)
            {
                $output[] = $event;
            }
        }

        asort($output);
        return $output;
    }
}