@extends('layouts.frontend')

@section('content')
<main class="my-8">
  <div class="container px-6 mx-auto">
    <div class="flex justify-center my-6">
      <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <h3 class="text-3xl text-bold">Lista carrito</h3>
        <div class="flex-1">
          <table class="w-full text-sm lg:text-base" cellspacing="0">
            <thead>
              <tr class="h-12 uppercase">
                <th class="hidden md:table-cell"></th>
                <th class="text-left">Nombre</th>
                <th class="pl-5 text-left lg:text-right lg:pl-0">
                  <span class="lg:hidden" title="Cantidad">Qtd</span>
                  <span class="hidden lg:inline">Cantidad</span>
                </th>
                <th class="hidden text-right md:table-cell"> Precio</th>
                <th class="hidden text-right md:table-cell"> Remover </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cartItems as $item)
              <tr>
                <td class="hidden pb-4 md:table-cell">
                  <a href="#">
                    <img src="{{ $item->attributes->image }}" class="w-20 rounded" alt="Thumbnail">
                  </a>
                </td>
                <td>
                  <a href="#">
                    <p class="mb-2 md:ml-4">{{ $item->name }}</p>

                  </a>
                </td>
                <td class="justify-center mt-6 md:justify-end md:flex">
                  <div class="h-10 w-28">
                    <div class="relative flex flex-row w-full h-8">

                      <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id}}">
                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-6 text-center bg-gray-300" />
                        <button type="submit" class="px-2 pb-2 ml-2 text-white bg-blue-500">update</button>
                      </form>
                    </div>
                  </div>
                </td>
                <td class="hidden text-right md:table-cell">
                  <span class="text-sm font-medium lg:text-base">
                    ${{ $item->price }}
                  </span>
                </td>
                <td class="hidden text-right md:table-cell">
                  <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <button class="px-4 py-2 text-white bg-red-600">x</button>
                  </form>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div>
            Total: ${{ Cart::getTotal() }}
          </div>
          <div>
            <form action="{{ route('cart.clear') }}" method="POST">
              @csrf
              <button class="px-6 py-2 text-red-800 bg-red-300">Remover todo el carrito</button>
            </form>
          </div>
          <div>
            <br>
            <hr class="my-4">
            <form action="{{ route('cart.send') }}" method="POST">
              @csrf
              <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Datos de facturación</h4>
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label for="firstName" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="" required>
                  </div>

                  <div class="col-sm-6">
                    <label for="lastName" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="" required>
                  </div>

                  <div class="col-sm-6">
                    <label for="lastName" class="form-label">Documento</label>
                    <input type="text" class="form-control" name="document" id="document" placeholder="" value="" required>
                  </div>

                  <div class="col-sm-6">
                    <label for="lastName" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="" value="" required>
                  </div>

                  <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com">
                  </div>

                  <div class="col-12">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                      Please enter your shipping address.
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="address2" class="form-label">Dirección 2 <span class="text-muted">(Opcional)</span></label>
                    <input type="text" class="form-control" name="address2" id="address2" placeholder="Casa o apartamento">
                  </div>

                  <div class="col-md-4">
                    <label for="country" class="form-label">País</label>
                    <select class="form-select" name="country" id="country" required>
                      <option value="">Elegir...</option>
                      <option>Colombia</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="state" class="form-label">Departamento</label>
                    <select class="form-select" name="state" id="state" required>
                      <option value="">Elegir...</option>
                      <option>Antioquia</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="state" class="form-label">Ciudad</label>
                    <select class="form-select" name="city" id="city" required>
                      <option value="">Elegir...</option>
                      <option>Medellín</option>
                    </select>
                  </div>

                </div>

                <hr class="my-4">

                <h4 class="mb-3">Método de pago</h4>

                <div class="my-3">
                  <div class="form-check">
                    <input id="debit" name="paymentMethod" type="radio" value="placetopay" class="form-check-input" required>
                    <label class="form-check-label" for="debit">PlaceToPay</label>
                  </div>
                  <div class="form-check">
                    <input id="paypal" name="paymentMethod" type="radio" value="paypal" class="form-check-input" required>
                    <label class="form-check-label" for="paypal">PayPal</label>
                  </div>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg" type="submit">Continuar con la compra</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection