@component('admin.layouts.content' , ['title' => 'ویرایش سفارش'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارشات</a></li>
        <li class="breadcrumb-item active">ویرایش سفارش</li>
    @endslot

    @slot('css')
        <style>

            /* date picker */
            #plotId {
                font-family: 'Vazir', sans-serif !important;
            }

        </style>
    @endslot

    @slot('script')
        <script>

{{--    because we use select2 in user field, we use following code instead of {{ old('user' , $order->user_id) == $user ? 'selected' : '' }} in user field  --}}
            $('#user').select2({
                'placeholder' : 'کاربر مورد نظر را انتخاب کنید'
            }).val({{$order->user_id}}).change();

            $(document).ready(function() {

                $("#created_at").pDatepicker({
                    autoClose: true,
                    format: 'YYYY/MM/DD HH:mm:ss',
                    viewMode: 'year',
                    position: 'auto',
                    position: [40,1000],
                    //altField: '#created_at_Alt',
                    //altFormat: 'u',
                    timePicker: {
                        enabled: true,
                    },
                    toolbox:{
                        calendarSwitch:{
                            enabled: false
                        }
                    },
                    //initialValueType: 'persian'

                });

                //set default value in create_at field from db
                $("#created_at").val('{{$createdAtDefaultValue}}');

            });

            let changeCategoryValues = (event , id) => {

                //first reset quantity field
                let quantityID = `quantity-${id}`;
                var valueBoxQuantity = $("#" + quantityID).get(0);
                while (valueBoxQuantity.options.length > 0) {
                    valueBoxQuantity.remove(0);
                }

                let valueBoxProduct = $(`select[name='products[${id}][productID]']`);

                $.ajaxSetup({
                    headers : {
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type' : 'application/json'
                    }
                })

                $.ajax({
                    type : 'POST',
                    url : '/admin/productValuesBaseCategoryID',
                    data : JSON.stringify({
                        categoryID : event.target.value
                    }),
                    success : function(data) {
                        //console.log(data.data);

                        valueBoxProduct.html(`
                            <option selected>انتخاب کنید</option>
                            ${
                            data.data.map(function (item) {
                                return `<option value="${item.id}"  data-inventory="${item.inventory}">${item.title}</option>`
                            })
                        }
                        `);

                        $('.product-select').select2({ tags : false });
                    }
                });
            }

            let changeProductValues = (event , id) => {

                let inventory = event.target.selectedOptions[0].getAttribute("data-inventory");

                let quantityID = `quantity-${id}`;

                var valueBoxQuantity = $("#" + quantityID).get(0);

                //first reset quantity field
                while (valueBoxQuantity.options.length > 0) {
                    valueBoxQuantity.remove(0);
                }

                //then create options
                for (var i=1; i <= inventory; i++) {
                    newOption = document.createElement("option");
                    newOption.value = i;
                    newOption.text= i;
                    valueBoxQuantity.appendChild(newOption);
                }

            }

            let createNewProduct = ({ categories , id }) => {
                return `
                    <div class="row" id="product-${id}">
                        <div class="col-4">
                            <div class="form-group">
                                 <label>دسته بندی</label>
                                 <select name="products[${id}][categoryID]" onchange="changeCategoryValues(event, ${id});" class="product-select form-control">
                                    <option value="">انتخاب کنید</option>
                                    ${
                    categories.map(function(item) {
                        return `<option value="${item.id}">${item.name}</option>`
                    })
                }
                                 </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                 <label>محصول</label>
                                 <select name="products[${id}][productID]" onchange="changeProductValues(event, ${id});" class="product-select form-control">
                                        <option value="">انتخاب کنید</option>
                                 </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                 <label>تعداد</label>
                                 <select name="products[${id}][quantity]" class="form-control" id="quantity-${id}">

                                 </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('product-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
            }

            $('#add_product').click(function() {
                let productSection = $('#product_section');
                let id = productSection.children().length;
                let categories = $('#categories').data('type');

                productSection.append(
                    createNewProduct({
                        categories,
                        id
                    })
                );

                $('.product-select').select2({ tags : false });
            });

        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش</h3>
                </div>
                <!-- /.card-header -->
                <div id="categories" data-type="{{ \App\Models\Category::all() }}"></div>
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.orders.update' , $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام کاربر</label>
                            <select name="user" class="form-control" id="user">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value=""></option>
                                    {{-- <option value="{{ $user->id }}" {{ old('user') == $user ? 'selected' : '' }}>{{ $user->name }}</option>      --}}
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">تاریخ ثبت</label>
                            <input type="text" name="created_at" class="form-control created_at" id="created_at">

                            {{--                            <input id="created_at_Alt" class="form-control" name="created_at_Alt">--}}
                            {{--                            <input class="created_at" name="created_at">--}}

                        </div>

                        <div class="form-group">
                            <label for="order_price" class="col-sm-2 control-label">قیمت کل</label>
                            <input type="text" name="order_price" class="form-control" id="order_price" >
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">وضعیت</label>
                            <select name="status" class="form-control" id="status">
                                @foreach($statusEnums as $item)
                                    <option value="{{ $item }}" {{ old('status') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tracking_serial" class="col-sm-2 control-label">کد رهگیری پستی</label>
                            <input type="text" name="tracking_serial" class="form-control" id="tracking_serial">
                        </div>

                        <h6>محصولات</h6>
                        <hr>
                        <div id="product_section">

                        </div>
                        <button class="btn btn-sm btn-danger" type="button" id="add_product">افزودن محصول</button>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش سفارش</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

