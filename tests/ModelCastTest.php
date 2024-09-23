<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DirectoryTree\ActiveRedis\Tests\Fixtures\ModelStubWithCasts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redis;

beforeEach(fn () => Redis::flushall());

it('casts json correctly', function () {
    $model = new ModelStubWithCasts;

    $model->json = [
        'name' => 'John',
        'age' => 30,
    ];

    $model->save();
    $model->refresh();

    expect($model->json)->toBeArray();
    expect($model->json['name'])->toEqual('John');
    expect($model->json['age'])->toEqual(30);
});

it('casts array correctly', function () {
    $model = new ModelStubWithCasts;

    $model->array = [1, 2, 3];

    $model->save();
    $model->refresh();

    expect($model->array)->toBeArray();
    expect($model->array)->toEqual([1, 2, 3]);
});

it('casts date correctly', function () {
    $model = new ModelStubWithCasts;

    $model->date = now()->format('Y-m-d');

    $model->save();
    $model->refresh();

    expect($model->date)->toBeInstanceOf(Carbon::class);
    expect($model->date)->toEqual(Date::today());
    expect($model->date)->isSameDay(now());
});

it('casts string correctly', function () {
    $model = new ModelStubWithCasts;

    $model->string = 123;

    $model->save();
    $model->refresh();

    expect($model->string)->toBeString();
    expect($model->string)->toEqual('123');
});

it('casts object correctly', function () {
    $model = new ModelStubWithCasts;

    $object = new stdClass;
    $object->name = 'John';
    $object->age = 30;

    $model->object = $object;

    $model->save();
    $model->refresh();

    expect($model->object)->toBeObject();
    expect($model->object)->toBeInstanceOf(stdClass::class);
    expect($model->object->name)->toEqual('John');
    expect($model->object->age)->toEqual(30);
});

it('casts decimal correctly', function () {
    $model = new ModelStubWithCasts;

    $model->decimal = 123.456789;

    $model->save();
    $model->refresh();

    expect($model->decimal)->toBeString();
    expect($model->decimal)->toEqual('123.46');
});

it('casts timestamp correctly', function () {
    $model = new ModelStubWithCasts;

    $model->timestamp = Date::now()->timestamp;

    $model->save();
    $model->refresh();

    expect($model->timestamp)->toBeInt();
    expect($model->timestamp)->toEqual(Date::now()->getTimestamp());
});

it('casts collection correctly', function () {
    $model = new ModelStubWithCasts;

    $model->collection = new Collection([1, 2, 3]);

    $model->save();
    $model->refresh();

    expect($model->collection)->toBeInstanceOf(Collection::class);
    expect($model->collection)->toEqual(collect([1, 2, 3]));
});

it('casts integer correctly', function () {
    $model = new ModelStubWithCasts;

    $model->integer = 123;

    $model->save();
    $model->refresh();

    expect($model->integer)->toBeInt();
    expect($model->integer)->toEqual(123);
});

it('casts boolean correctly', function () {
    $model = new ModelStubWithCasts;

    $model->save();
    $model->refresh();

    $model->boolean = '1';
    expect($model->boolean)->toBeTrue();

    $model->save();
    $model->refresh();

    $model->boolean = '0';
    expect($model->boolean)->toBeFalse();
});

it('casts float correctly', function () {
    $model = new ModelStubWithCasts;

    $model->float = '123.45';

    $model->save();
    $model->refresh();

    expect($model->float)->toBeFloat();
    expect($model->float)->toEqual(123.45);
});

it('casts datetime correctly', function () {
    $model = new ModelStubWithCasts;

    $model->datetime = '2024-09-24 15:30:00';

    $model->save();
    $model->refresh();

    expect($model->datetime)->toBeInstanceOf(Carbon::class);
    expect($model->datetime)->toEqual(Carbon::parse('2024-09-24 15:30:00'));
});

it('casts custom_datetime correctly', function () {
    $model = new ModelStubWithCasts;

    $model->custom_datetime = '2024-09-24';

    $model->save();
    $model->refresh();

    expect($model->custom_datetime)->toBeInstanceOf(Carbon::class);
    expect($model->custom_datetime)->toEqual(Carbon::parse('2024-09-24 00:00:00'));
});

it('casts immutable_date correctly', function () {
    $model = new ModelStubWithCasts;

    $model->immutable_date = '2024-09-24';

    $model->save();
    $model->refresh();

    expect($model->immutable_date)->toBeInstanceOf(CarbonImmutable::class);
    expect($model->immutable_date)->toEqual(CarbonImmutable::parse('2024-09-24 00:00:00'));
});

it('casts immutable_datetime correctly', function () {
    $model = new ModelStubWithCasts;

    $model->immutable_datetime = '2024-09-24 15:30:00';

    $model->save();
    $model->refresh();

    expect($model->immutable_datetime)->toBeInstanceOf(CarbonImmutable::class);
    expect($model->immutable_datetime)->toEqual(CarbonImmutable::parse('2024-09-24 15:30:00'));
});
