<?php

function wow_api_quota_is_exceeded()
{
    // Check time
    $time = get_database_config("wow-query-quota-timestamp");
    if ($time == "")
    {
        set_database_config("wow-query-quota-count", "0");
    }
    else
    {
        $now = time();
        $nextQuotaReset = $now - 86400;     //86400 = 1 day
        if ($nextQuotaReset > intval($time))
        {
            // One day is passed now.
            set_database_config("wow-query-quota-count", "0");
            set_database_config("wow-query-quota-timestamp", "");
        }
    }
    
    $count = intval(get_database_config("wow-query-quota-count"));
    $max = intval(get_database_config("wow-query-quota-max"));
    
    return ($count >= $max);
}

?>