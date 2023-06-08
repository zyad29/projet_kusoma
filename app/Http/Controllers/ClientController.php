<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Commande;
use App\Cart;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

//use Session;

class ClientController extends Controller
{


    public function connexion()
    {
        return view('client.connexion');
    }
    public function inscription()
    {
        return view('client.inscription');
    }
    //
    public function home()
    {
        $sliders = Slider::where('status', 1)->get();
        $produits = Product::where('status', 1)->get();
        return view('client.home')->with('sliders', $sliders)->with('produits', $produits);
    }

    public function shop()
    {
        $categories = Category::get();
        $produits = Product::where('status', 1)->get();
        return view('client.shop')->with('categories', $categories)->with('produits', $produits);
    }

    public function select_par_cat($name)
    {
        $categories = Category::get();
        $produits = Product::where('product_category', $name)->where('status', 1)->get();
        return view('client.shop')->with('produits', $produits)->with('categories', $categories);
    }

    public function ajouter_au_panier($id)
    {
        $produit = Product::find($id);

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($produit, $id);
        Session::put('cart', $cart);

        //dd(Session::get('cart'));
        return Redirect::to('/shop');
        //return redirect('/shop');
    }

    public function panier()
    {
        if (!Session::has('cart')) {
            return view('client.cart');
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        return view('client.cart', ['products' => $cart->items]);
    }

    public function modifier_panier($id, Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateQty($id, $request->quantity);
        Session::put('cart', $cart);

        //dd(Session::get('cart'));
        return Redirect::to('/panier');
    }

    public function retirer_produit($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        //dd(Session::get('cart'));
        return Redirect::to('/panier');
    }

    public function paiement()
    {
        if (!Session::has('client')) {
            return view('client.login');
        }

        if (!Session::has('cart')) {
            return view('client.cart');
        }

        return view('client.checkout');
    }

    public function payer(Request $request)
    {
        if (!Session::has('cart')) {
            return view('client.cart');
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);


        Stripe::setApiKey('sk_test_51Ms4mpCSsKgxtvP77477pwHCZplUS9Skjfch6q2QzsOCpvoylAmEo1neXEf1qQRB7g0z57Ua50BcMkIDe6bGgU9u00qux9Mt1G');

        try {

            $charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtainded with checkout.js
                "description" => "Test Charge"
            ));

            $order = new Commande();
            $order->nom = $request->input('name');
            $order->adress = $request->input('adress');
            $order->panier = serialize($cart);
            $order->payment_id = $charge->id;

            $order->save();

            $orders = Commande::where('payment_id', $charge->id)->get();

            $orders->transform(function ($order, $key) {

                $order->panier = unserialize($order->panier);

                return $order;
            });

            $email = Session::get('client')->email;

            Mail::to($email)->send(new SendMail($orders));
        } catch (\Exception $e) {
            Session::put('error', $e->getMessage());
            return Redirect::to('/paiement');
        }

        Session::forget('cart');
        //Session::put('success', 'Purchase accomplished successfully !');
        return Redirect::to('/panier')->with('status', 'Achat accompli avec succès');
    }

    public function creer_compte(Request $request)
    {

        $this->validate($request, [
            'nomClient' => 'required',
            'prenomClient' => 'required',
            'email' => 'email|required|unique:clients',
            'password' => 'required|min:10'
        ]);

        $client = new Client();
        $client->nomClient = $request->input('nomClient');
        $client->prenomClient = $request->input('prenomClient');
        $client->email = $request->input('email');
        $client->password = bcrypt($request->input('password'));

        $client->save();



        return back()->with('status', 'Votre compte a été crée avec succès');
    }



























    public function acceder_compte(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $client = Client::where('email', $request->input('email'))->first();
        if ($client) {

            if (Hash::check($request->input('password'), $client->password)) {
                Session::put('client', $client);
                // return redirect('/shop');
                return redirect('/client_login')->with('status', 'Vous venez de vous connecter');
            } else {
                return back()->with('status', 'Votre mot de passe ou email est incorrect');
            }
        } else {
            return back()->with('status', 'Votre compte n' . "'" . 'est pas enregistré');
        }
    }

    public function logout()
    {
        Session::forget('client');
        return back();
    }

    public function client_login()
    {
        return view('client.login');
    }

    public function signup()
    {
        return view('client.signup');
    }
}
