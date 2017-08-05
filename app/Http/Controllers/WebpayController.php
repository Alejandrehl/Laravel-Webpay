<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\WebPay;
use Illuminate\Http\Request;
use Redirect;

class WebpayController extends Controller {
	/**
	 * Inicializar webpay
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function init() {
		$producto = \Session::get('cart');

		$init = [
			'buyId' => $producto['id'],
			'amount' => $producto['precio'],
			'urlReturn' => route('webpay.voucher'),
			'urlFinal' => route('webpay.finish'),
		];

		/* Inicializamos webpay */
		$webpay = new WebPay($init);
		$webpay->process($init);

		/* Comprobamos que los certificados sean válidos */
		if ($webpay->getError() != '') {
			return Redirect::route('webpay.rechazo');
		}

		return Redirect::route("webpay.token")
			->with('token', $webpay->getToken())
			->with('url', $webpay->getUrl());
	}

	/**
	 * Formulario con auto submit.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function token() {
		return view("webpay.token");
	}

	/**
	 * Página de éxito
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function exito() {
		return view("webpay.exito");
	}

	/**
	 * Página de rechazo
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function rechazo() {
		return view("webpay.rechazo");
	}

	/**
	 * Generación del voucher
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function voucher(Request $request) {

		$init = [];
		$init['comercio_codigo'] = config('webpay.codigo_de_comercio');

		if (!$request->get('token_ws')) {
			return 'Error. No token recibido';
		}

		$webpay = new Webpay($init);
		$result = $webpay->getTransactionToken($request->get('token_ws'));

		if (isset($result->detailOutput)) {
			if (isset($result->detailOutput->responseCode) && $result->detailOutput->responseCode === 0) {
				// Compra exitosa
				\Session::put('compra', 1);

				return Redirect::route("webpay.token")
					->with('token', $request->get('token_ws'))
					->with('url', $result->urlRedirection);

			} else {
				// Error a comprar
				\Session::put('compra', 0);

				return Redirect::route('webpay.rechazo');
			}
		} else {
			// Error
			\Session::put('compra', 0);

			return Redirect::route('webpay.rechazo');
		}

	}

	/**
	 * Finaliza la compra en Webpay
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function finish(Request $request) {
		if (\Session::get('compra')) {
			return Redirect::route('webpay.exito');
		} else {
			return Redirect::route('webpay.rechazo');
		}
	}

}
