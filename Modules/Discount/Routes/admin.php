<?php

Route::resource('discounts', DiscountController::class)->except(['show']);
