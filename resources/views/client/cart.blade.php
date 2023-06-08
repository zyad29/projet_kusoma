


      @extends('layouts.app1')
     {{--start content--}}

      @section('contenu')

      <div class="hero-wrap hero-bread" style="background-image: url('frontend/images/photo2.jpg');">
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">Accueil</a></span> <span>Panier</span></p>
              <h1 class="mb-0 bread">Mon Panier</h1>
            </div>
          </div>
        </div>
      </div>
  
      <section class="ftco-section ftco-cart">
              <div class="container">
                  <div class="row">
                  <div class="col-md-12 ftco-animate">
                      <div class="cart-list">
                          <table class="table">
                              <thead class="thead-primary">
                                <tr class="text-center">
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>Nom du produit</th>
                                  <th>Prix</th>
                                  <th>Quantité</th>
                                  <th>Total</th>
                                </tr>
                              </thead>

                              @if(Session::has('cart'))
                              <tbody>
                                @foreach($products as $product)

                                <tr class="text-center">
                                  <td class="product-remove"><a href="/retirer_produit/{{$product['product_id']}}"><span class="ion-ios-close"></span></a></td>
                                  
                                  <td class="image-prod"><div class="img" style="background-image:url(/storage/product_images/{{$product['product_image']}});"></div></td>
                                  
                                  <td class="product-name">
                                      <h3>{{$product['product_name']}}</h3>
                                      {{-- <p>Far far away, behind the word mountains, far from the countries</p> --}}
                                  </td>
                                  
                                  <td class="price">{{$product['product_price']}}€</td>
                                  <form action="{{url('/modifier_qty/'.$product['product_id'])}}" method="POST">
                                    {{ csrf_field() }}
                                      <td class="quantity">
                                          <div class="input-group mb-3">
                                          <input type="number" name="quantity" class="quantity form-control input-number" value="{{$product['qty']}}" min="1">
                                      </div>
                                      <input type="submit" value="Modifier" class="btn btn-success">
                                    </td>
                                  </form>
     
                               
                                  
                                  <td class="total">{{$product['product_price'] * $product['qty']}}€</td>
                                </tr><!-- END TR-->
  
                               
                                @endforeach
                                
                              </tbody>
                              @else 
                                  @if (Session::get('status'))
                                  <div class="alert alert-success">
                                    {{Session::get('status')}}
                                  </div>
                                  @endif
                              @endif
                            </table>
                        </div>
                  </div>
              </div>
              <div class="row justify-content-end">
                  <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
                      {{-- <div class="cart-total mb-3">
                          <h3>Cart Totals</h3>
                          
                          <hr>
                          <p class="d-flex total-price">
                              <span>Total</span>
                              <span>$</span>
                          </p>
                      </div> --}}
                      <p><a href="{{URL::to('/paiement')}}" class="btn btn-primary py-3 px-4">Procéder au règlement</a></p>
                  </div>
              </div>
              </div>
          </section>

      @endsection

     {{--end content--}}

     @section('scripts')
     
     <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>

     @endsection



   

		
  
    
  </body>
</html>