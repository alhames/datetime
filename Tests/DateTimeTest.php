<?php

namespace Alhames\DateTime\Tests;

use Alhames\DateTime\DT;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    private const DATE_EXAMPLE = '2020-01-01 10:10:10';

    public function testToString(): void
    {
        $date = new DT(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));
        $this->assertSame('2020-01-01T10:10:10+00:00', (string) $date);
    }

    public function testCreateFromTimestamp(): void
    {
        $timestamp = mktime(10, 10, 10, 1, 1, 2020);
        $date = DT::createFromTimestamp($timestamp);
        $this->assertInstanceOf(DT::class, $date);
        $this->assertSame($timestamp, $date->getTimestamp());
    }

    public function testCreateStartOfHour(): void
    {
        $dateFromString = DT::createStartOfHour(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DT::class, $dateFromString);
        $this->assertSame('2020-01-01 10:00:00', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DT::createStartOfHour($dateObject);
        $this->assertInstanceOf(DT::class, $dateFromObject);
        $this->assertSame('2020-01-01 10:00:00', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateEndOfHour(): void
    {
        $dateFromString = DT::createEndOfHour(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DT::class, $dateFromString);
        $this->assertSame('2020-01-01 10:59:59', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DT::createEndOfHour($dateObject);
        $this->assertInstanceOf(DT::class, $dateFromObject);
        $this->assertSame('2020-01-01 10:59:59', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateStartOfDay(): void
    {
        $dateFromString = DT::createStartOfDay(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DT::class, $dateFromString);
        $this->assertSame('2020-01-01 00:00:00', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DT::createStartOfDay($dateObject);
        $this->assertInstanceOf(DT::class, $dateFromObject);
        $this->assertSame('2020-01-01 00:00:00', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateEndOfDay(): void
    {
        $dateFromString = DT::createEndOfDay(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DT::class, $dateFromString);
        $this->assertSame('2020-01-01 23:59:59', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DT::createEndOfDay($dateObject);
        $this->assertInstanceOf(DT::class, $dateFromObject);
        $this->assertSame('2020-01-01 23:59:59', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testJsonSerialize(): void
    {
        $date = new DT(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));
        $this->assertSame('"2020-01-01T10:10:10+00:00"', \json_encode($date));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testGet(string $expected, \DateTimeInterface $date): void
    {
        $this->assertInstanceOf(DT::class, $date);
        $this->assertSame($expected, $date->format('Y-m-d H:i:s'));
    }

    public function getDataProvider(): array
    {
        $date = new DT(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));

        return [
            ['2020-01-01 10:00:00', $date->getStartOfHour()],
            ['2020-01-01 10:59:59', $date->getEndOfHour()],
            ['2020-01-01 00:00:00', $date->getStartOfDay()],
            ['2020-01-01 23:59:59', $date->getEndOfDay()],
        ];
    }

    /**
     * @dataProvider functionDataProvider
     */
    public function testFunction(string $expected, $value): void
    {
        $date = dt($value);
        $this->assertInstanceOf(DT::class, $date);
        $this->assertSame($expected, $date->format('Y-m-d H:i:s.u'));
    }

    public function functionDataProvider(): array
    {
        return [
            ['2020-01-01 10:20:30.400000', '2020-01-01 10:20:30.40'],
            ['2020-01-01 10:20:30.400000', new DT('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.400000', new \DateTime('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.400000', new \DateTimeImmutable('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.000000', mktime(10, 20, 30, 01, 01, 2020)],
            ['2020-01-01 10:20:30.000000', (string) mktime(10, 20, 30, 01, 01, 2020)],
            ['2020-01-02 10:20:30.400000', '2020-01-01 10:20:30.40 + 1 day'],
        ];
    }
}
