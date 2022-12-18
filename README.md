# DateTime Extension

## Installation

```
$ composer require alhames/datetime
```

```json
{
    "require": {
        "alhames/datetime": "^1.0"
    }
}
```

## Examples of usage

```php
use Alhames\DateTime\DT;

// If now 22 Dec 2022, 10:20:30 Europe/Moscow (+03:00)

echo dt(); // 2022-12-22T10:20:30+03:00

// Create date from string
echo dt('now');           // 2022-12-22T10:20:30+03:00
echo dt('today');         // 2022-12-22T00:00:00+03:00
echo dt('-3 days');       // 2022-12-19T10:20:30+03:00
echo dt('-3 days 02:00'); // 2022-12-19T02:00:00+03:00

// Create date from object
echo dt(new \DateTime()); // 2022-12-22T10:20:30+03:00
echo dt(dt());            // 2022-12-22T10:20:30+03:00
echo dt(new DT());        // 2022-12-22T10:20:30+03:00

// Create date from timestamp
$timestamp = mktime(11, 12, 13, 10, 20, 2030);
echo dt(0);                               // 1970-01-01T03:00:00+03:00
echo dt($timestamp);                      // 2030-10-20T11:12:13+03:00
echo dt((string) $timestamp);             // 2030-10-20T11:12:13+03:00
echo dt($timestamp - DT::YEAR * 3);       // 2027-10-21T11:12:13+03:00
echo DT::createFromTimestamp($timestamp); // 2030-10-20T11:12:13+03:00

// Create start/end of day/hour
echo dt()->getStartOfDay();   // 2022-12-22T00:00:00+03:00
echo dt()->getEndOfDay();     // 2022-12-22T23:59:59+03:00
echo dt()->getStartOfHour();  // 2022-12-22T10:00:00+03:00
echo dt()->getEndOfHour();    // 2022-12-22T10:59:59+03:00
echo DT::createStartOfDay();  // 2022-12-22T00:00:00+03:00
echo DT::createEndOfDay();    // 2022-12-22T23:59:59+03:00
echo DT::createStartOfHour(); // 2022-12-22T10:00:00+03:00
echo DT::createEndOfHour();   // 2022-12-22T10:59:59+03:00

// DT is immutable
$dt = dt();
echo $dt->getStartOfHour(); // 2022-12-22T10:00:00+03:00
echo $dt;                   // 2022-12-22T10:20:30+03:00
echo $dt->setTime(3, 15);   // 2022-12-22T03:15:00+03:00
echo $dt;                   // 2022-12-22T10:20:30+03:00

// Another examples
sleep(DT::HOUR);                  // sleep for 1 hour
usleep(DT::getMicroseconds(1.5)); // sleep for 1.5 seconds

echo json_encode(['now' => dt()]); // {"now":"2022-12-22T10:20:30+03:00"}
dt()->format(DT::FORMAT_MYSQL);    // 2022-12-22 10-20-30
```
