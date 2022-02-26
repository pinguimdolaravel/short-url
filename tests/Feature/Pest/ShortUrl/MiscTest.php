<?php

it('has a home page')
    ->get('/')
    ->assertOk();

it('is incomplete');

it('will not run')->skip();

test('only this test will run! (//comment me out)')
    ->expect(true)->toBeTrue()
    ->only();
