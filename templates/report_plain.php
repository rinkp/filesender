<?php

$lines = array();
foreach($report->logs as $entry) {
    $date = Utilities::formatDate($entry->created);
    
    $lid = 'report_';
    if($report->target_type == 'Recipient')
        $lid .= 'recipient_';
    
    if($entry->author_type == 'Guest')
        $lid .= 'guest_';
    
    $lid .= 'event_'.$entry->event;
    
    $action = Lang::tr($lid)->r(
        array(
            'author' => $entry->author,
            'log' => $entry
        ),
        $entry->target
    );
    
    $lines[] = array('date' => $date, 'action' => $action);
}

// Find longest date to compute first column width
$dw = max(array_map(function($line) {
    return strlen($line['date']);
}, $lines));

foreach($lines as $line) {
    echo $line['date'].str_repeat(' ', $dw - strlen($line['date'])).' : ';
    
    echo chunk_split($line['action'], 76, GlobalConstants::NEW_LINE.str_repeat(' ', $dw + 3));
}
