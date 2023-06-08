@extends('layouts.appadmin')

@section('title')
        Ajouter produit
@endsection
@section('contenu')




        <div class="row grid-margin">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ajouter produit</h4>
                  @if(Session::has('status'))
                  <div class="alert alert-success">
                    {{Session::get('status')}}
                  </div>
                  @endif
                  @if(count($errors)> 0)
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                  </div>
                  @endif
                  
                    {!!Form::open(['action' => ['App\Http\Controllers\ProductController@sauverproduit'], 'method' => 'POST', 'class' => 'cmxform', 'id' => 'commentForm', 'enctype' => 'multipart/form-data'])!!}
                    {{ csrf_field() }}
                      <div class="form-group">
                        {{Form::label('', 'Nom du produit', ['for' => 'cname'])}}
                        {{Form::text('product_name', '', ['class' => 'form-control', 'id' => 'cname'])}}
         
                      </div>
                      <div class="form-group">
                        {{Form::label('', 'Prix du produit', ['for' => 'cname'])}}
                        {{Form::number('product_price', '', ['class' => 'form-control', 'id' => 'cname'])}}
         
                      </div>
                      <div class="form-group">
                        {{Form::label('', 'Catégorie du produit')}}
                        {{Form::select('product_category', $categories, null, ['placeholder' => 'Select category', 'class' => 'form-control'])}} 

                        {{-- <select name="" id="">
                          <option value="">Select</option>
                          @foreach($categories as $categorie)
                            <option value="">{{$categorie->category_name}}</option>
                          @endforeach
                        </select> --}}
         
                      </div>
                      <div class="form-group">
                        {{Form::label('', 'Image du produit', ['for' => 'cname'])}}
                        {{Form::file('product_image', ['class' => 'form-control', 'id' => 'cname'])}}
         
                      </div>

                      
                      {{Form::submit('Ajouter', ['class' => 'btn btn-primary'])}}
                    {!!Form::close()!!}
                  
                </div>
              </div>
            </div>
          </div>
       
@endsection

@section('scripts')

    {{-- <script src="backend/js/form-validation.js"></script>
    <script src="backend/js/bt-maxLength.js"></script> --}}

@endsection