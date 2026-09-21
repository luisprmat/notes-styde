<?php

use function Pest\Laravel\get;

test('the application returns a successful response', function () {
    $response = get('/notas');

    $response->assertStatus(200);
});
