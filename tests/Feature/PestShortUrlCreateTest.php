<?php

it('has pestshorturlcreate page', function () {
    $response = $this->get('/pestshorturlcreate');

    $response->assertStatus(200);
});
