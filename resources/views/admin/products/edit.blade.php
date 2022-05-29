@component('admin.layouts.content' , ['title' => 'ویرایش محصولات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot

    @slot('script')
        <script>

            $('#categories').select2({
                'placeholder' : 'دسترسی مورد نظر را انتخاب کنید'
            });


            let changeAttributeValues = (event , id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers : {
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type' : 'application/json'
                    }
                })

                $.ajax({
                    type : 'POST',
                    url : '/admin/attribute/values',
                    data : JSON.stringify({
                        name : event.target.value
                    }),
                    success : function(data) {
                        valueBox.html(`
                            <option selected>انتخاب کنید</option>
                            ${
                            data.data.map(function (item) {
                                return `<option value="${item}">${item}</option>`
                            })
                        }
                        `);

                        $('.attribute-select').select2({ tags : true });
                    }
                });
            }

            let createNewAttr = ({ attributes , id }) => {
                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                 <label>عنوان ویژگی</label>
                                 <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                    <option value="">انتخاب کنید</option>
                                    ${
                    attributes.map(function(item) {
                        return `<option value="${item}">${item}</option>`
                    })
                }
                                 </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                 <label>مقدار ویژگی</label>
                                 <select name="attributes[${id}][value]" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                 </select>
                            </div>
                        </div>
                         <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
            }

            $('#add_product_attribute').click(function() {
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length;
                let attributes = $('#attributes').data('type');

                attributesSection.append(
                    createNewAttr({
                        attributes,
                        id
                    })
                );

                $('.attribute-select').select2({ tags : true });
            });

        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش اجازه دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <div id="attributes" data-type="{{ \App\Models\Attribute::all()->pluck('name') }}"></div>
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.products.update' , $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="عنوان را وارد کنید" value="{{ old('title', $product->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea name="description" class="form-control" id="description">
                                {{ old('description', $product->description) }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="قیمت را وارد کنید" value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory" placeholder="موجودی را وارد کنید" value="{{ old('inventory', $product->inventory) }}">
                        </div>
                        <div class="form-group">
                            <label for="categories" class="col-sm-2 control-label">دسته ها</label>
                            <select name="categories[]" class="form-control" id="categories" multiple>
                                @foreach(\App\Models\Category::all() as $cate)
                                    <option value="{{ $cate->id }}" {{ in_array($cate->id , $product->categories()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $cate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <h6>ویژگی محصول</h6>
                        <hr>
                        <div id="attribute_section">
                            @foreach($product->attributes as $attr)
                                <div class="row" id="attribute-{{ $loop->index }}">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>عنوان ویژگی</label>
                                            <select name="attributes[{{ $loop->index}}][name]" onchange="changeAttributeValues(event, {{ $loop->index}});" class="attribute-select form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach(\App\Models\Attribute::all() as $attribute)
                                                    <option value="{{ $attribute->name }}" {{ $attr->name ==  $attribute->name ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>مقدار ویژگی</label>
                                            <select name="attributes[{{ $loop->index }}][value]" class="attribute-select form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach(\App\Models\AttributeValue::all() as $attributeValue)
                                                    <option value="{{ $attributeValue->value }}" {{ $attr->pivot->value_id == $attributeValue->id ? 'selected' : '' }}>{{ $attributeValue->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label >اقدامات</label>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-{{ $loop->index }}').remove()">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <button class="btn btn-sm btn-danger" type="button" id="add_product_attribute">ویژگی جدید</button>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش محصول</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

