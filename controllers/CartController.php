<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\Cart;
use app\models\Order1;
use app\models\Order1Items;

class CartController extends AppController
{

	public function actionAdd(){

		if(Yii::$app->request->isAjax){

			$id = Yii::$app->request->get('id');
			$qty = (int)Yii::$app->request->get('qty');
        	$qty = !$qty ? 1: $qty;
			//var_dump($qty);
			$color = Yii::$app->request->get('color');
			$size = Yii::$app->request->get('size');

			$product = Product::findOne($id);
			if(empty($product)) return false;
			//var_dump($product);
			$session = Yii::$app->session;
			$session->open();
			$cart = new Cart();
			$cart->addToCart($product, $qty, $color, $size);
		}
		else{

			$id = Yii::$app->request->get('id');
			$qty = (int)Yii::$app->request->get('qty');
        	$qty = !$qty ? 1: $qty;
			//var_dump($qty);
			$product = Product::findOne($id);
			if(empty($product)) return false;
			//var_dump($product);
			$session = Yii::$app->session;
			$session->open();
			$cart = new Cart();
			$cart->addToCart($product, $qty);
			
            return $this->redirect(Yii::$app->request->referrer);
        }

		$this->layout = false;
		return $this->render('cart-modal', compact('session'));

	}

	public function actionClear(){
		$session = Yii::$app->session;
		$session->open();
		$session->remove('cart');
		$session->remove('cart.qty');
		$session->remove('cart.sum');
		$this->layout = false;
		return $this->render('cart-modal', compact('session'));
	}

	public function actionDelItem(){
		if(Yii::$app->request->isAjax){
			$id = Yii::$app->request->get('id');
			$session = Yii::$app->session;
			$session->open();
			$cart = new Cart();
			$cart->recalc($id);
			$this->layout = false;
			return $this->render('cart-modal', compact('session'));
		}
	}

	public function actionDelItemOrder(){
		if(Yii::$app->request->isAjax){
			$id = Yii::$app->request->get('id');
			$session = Yii::$app->session;
			$session->open();
			$cart = new Cart();
			$cart->recalc($id);
			$this->layout = false;
			return $this->redirect(['view', 'session'=>$session]);
		}
	}

	public function actionShow(){

		if(Yii::$app->request->isAjax){
			$session = Yii::$app->session;
			$session->open();
			$this->layout = false;
			return $this->render('cart-modal', compact('session'));
		}

	}

	public function actionView() {
            $session = Yii::$app->session;
            $session->open();
            $this->setMeta('Корзина');
            $order = new Order1();
            if($order->load(Yii::$app->request->post())) {
                $order->qty = $session['cart.qty'];
                $order->sum = $session['cart.sum'];
                if($order->save()) {
                    $this->saveOrderItems($session['cart'], $order->id);
                    Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер свяжется с Вами в ближайшее время');
                    
                    //Отправка почты
                    Yii::$app->mailer->compose('order', ['session' => $session])
                            ->setFrom(['el_dar34@mail.ru' => 'MaG'])
                            ->setTo($order->email)
                            ->setSubject('Order by '. $order->name)
                            ->send();
                    Yii::$app->mailer->compose('order', ['session' => $session])
                            ->setFrom(['el_dar34@mail.ru' => 'MaG'])
                            ->setTo(Yii::$app->params['adminEmail'])
                            ->setSubject('Order by '. $order->name)
                            ->send();
                    
                    
                    $session->remove('cart');
                    $session->remove('cart.qty');
                    $session->remove('cart.sum');
                    return $this->refresh();
                }else {
                    Yii::$app->session->setFlash('error', 'Ошибка офорления заказа');
                }
            }
            $this->layout = 'mainv';
            return $this->render('view', compact('session', 'order'));
        }

         protected function saveOrderItems($items, $order_id) {
            foreach ($items as $id => $item) {
                $order_items = new Order1Items();
                $order_items->order_id = $order_id;
                $order_items->product_id = $id;
                $order_items->name = $item['name'];
                $order_items->color = $item['color'];
                $order_items->size = $item['size'];
                $order_items->price = $item['price'];
                $order_items->qty_item = $item['qty'];
                $order_items->sum_item = $item['qty'] * $item['price'];
                $order_items->save();
            }
        }

}

?>