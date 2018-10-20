<?php

class Stripecore 
{
	public static function createCustomer($description, $email)
	{
		$response = new Response();

		try {

			$new_customer = \Stripe\Customer::create(array(
				"description" => $description,
				"email"=> $email
			));

			$custom_message = [
				"message" => 'Customer created successfully',
				"stripe_data" => $new_customer
			];

			$response->editSuccessResponseInfo($custom_message);

			return $response->success_response();

		  } catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly

			return $response->error_response();
		  } catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API

			return $response->error_response();
		  } catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)

			return $response->error_response();
		  } catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed

			return $response->error_response();
		  } catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email

			return $response->error_response();
		  } catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe

			return $response->error_response();
		  }
	}
}
