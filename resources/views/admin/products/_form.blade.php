@section('styles')
<style>
    .album {
        display: flex;
        margin-top: 10px
    }
    .album-item {
        margin: 0 10px;
        position: relative;
    }
    .album-item img {
        width: 80px;
        height: 60px;
        object-fit: cover;
    }
    .album-item a {
        position: absolute;
        right: 5px;
        top: 5px;
        width: 15px;
        height: 15px;
        background: #f00;
        border-radius: 50%;
        color: #fff;
        font-size: 9px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        transition: all .3s ease;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.21);
    }
    .album-item a:hover {
        background: #333;
    }
</style>
@stop

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>{{ __('site.EnglishName') }}</label>
            <input type="text" name="name_en" placeholder="{{ __('site.EnglishName') }}" class="form-control" value="{{ $product->name_en }}" />
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label>{{ __('site.ArabicName') }}</label>
            <input type="text" name="name_ar" placeholder="{{ __('site.ArabicName') }}" class="form-control" value="{{ $product->name_ar }}"/>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="image">{{ __('site.Image') }}</label>
    <input type="file" id="image" name="image" class="form-control" />
    @if ($product->image)
        <img width="80" src="{{ asset('uploads/products/'.$product->image) }}" alt="">
    @endif

</div>

<div class="mb-3">
    <label>{{ __('site.Album') }}</label>
    <input type="file" name="album[]" multiple class="form-control" />
    <div class="album">
        @foreach ($product->album as $img)
            <div class="album-item">
                <a href="{{ route('admin.products.delete_image', $img->id) }}"><i class="fas fa-times"></i></a>
                <img width="60" src="{{ asset('uploads/products/'.$img->path) }}" alt="">
            </div>
        @endforeach
    </div>
</div>

<div class="mb-3">
    <label>{{ __('site.EnglishContent') }}</label>
    <textarea name="content_en" placeholder="{{ __('site.EnglishContent') }}" class="myeditor">{{ $product->content_en }}</textarea>
</div>

<div class="mb-3">
    <label>{{ __('site.ArabicContent') }}</label>
    <textarea name="content_ar" placeholder="{{ __('site.ArabicContent') }}" class="myeditor">{{ $product->content_ar }}</textarea>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('site.Price') }}</label>
            <input type="text" name="price" placeholder="{{ __('site.Price') }}" class="form-control" value="{{ $product->price }}" />
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('site.SalePrice') }}</label>
            <input type="text" name="sale_price" placeholder="{{ __('site.SalePrice') }}" class="form-control" value="{{ $product->sale_price }}" />
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('site.Quantity') }}</label>
            <input type="text" name="quantity" placeholder="{{ __('site.Quantity') }}" class="form-control" value="{{ $product->quantity }}" />
        </div>
    </div>
</div>

<div class="mb-3">
    <label>{{ __('site.Category') }}</label>
    <select name="category_id" class="form-control">
        <option value="">{{ __('site.Select') }}</option>
        @foreach ($categories as $item)
            <option @selected($product->category_id == $item->id) value="{{ $item->id }}">{{ $item->trans_name }}</option>
        @endforeach
    </select>
</div>
