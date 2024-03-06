<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h2>  المشتريات </h2>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card">


                                    <div class="card-body">

                                        <fieldset class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3">اضافه حساب</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form method="post" enctype="multipart/form-data">

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-right m-t-30"
                                                                style="width: 100%; font-size: x-small">
                                                                <thead>
                                                                    <tr>

                                                                        <th> الحساب </th>

                                                                        <th> الرمز </th>
                                                                        <th> النوع </th>


                                                                        <!-- <th>رقم الحساب </th> -->

                                                                        <th>اضافه</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="index in count" :key="index">

                                                                        <td>
                                                                            <input v-model="account[index]" type="text"
                                                                                class="form-control" name="name" id="name"
                                                                                required />

                                                                        </td>



                                                                        <td>

                                                                            <input v-model="code[index]" type="text"
                                                                                class="form-control" name="name" id="name"
                                                                                required />


                                                                        </td>

                                                                        <td>

                                                                            <input v-model="type_account[index]" type="text"
                                                                                class="form-control" name="name" id="name"
                                                                                required />


                                                                        </td>


                                                                        <td v-if="index == 1">
                                                                            <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                                                v-on:click="addComponent(count)">
                                                                                <i class="fa fa-plus-circle"></i></a>

                                                                            <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                                                v-on:click="disComponent(count)">
                                                                                <i class="fa fa-minus-circle"></i></a>
                                                                        </td>



                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-primary"
                                                                                @click="add_new_account()">حفظ
                                                                            </button>


                                                                        </td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </fieldset>



                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card">

                                    <div class="card-header">
                                        <h2> ربط الحسابات </h2>
                                    </div>
                                    <div class="card-body">




                                        <fieldset v-if="list_data" class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3"> الرواتب</legend>
                                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                                v-if="accounts.type == 'salary'">

                                                <div class="col-md-2">
                                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id + accounts.account.first_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="inputAddress">الحساب المقابل</label>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>


                                        </fieldset>

                                        <fieldset v-if="list_data" class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3"> البدلات</legend>
                                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                                v-if="accounts.type == 'allowance'">
                                                <div class="col-md-2">
                                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id + accounts.account.first_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id"> 

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="inputAddress">الحساب المقابل</label>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>


                                            </div>


                                        </fieldset>


                                        <fieldset v-if="list_data" class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3"> الخصميات</legend>
                                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                                v-if="accounts.type == 'discount'">
                                                <div class="col-md-2">
                                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id + accounts.account.first_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="inputAddress">الحساب المقابل</label>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>


                                            </div>


                                        </fieldset>

                                        <fieldset v-if="list_data" class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3"> السلف</legend>
                                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                                v-if="accounts.type == 'advance'">
                                                <div class="col-md-2">
                                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id + accounts.account.first_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="inputAddress">الحساب المقابل</label>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>


                                            </div>


                                        </fieldset>

                                        <fieldset v-if="list_data" class="border rounded-3 p-3">
                                            <legend class="float-none w-auto px-3"> الاضافي</legend>
                                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                                v-if="accounts.type == 'extra'">
                                                <div class="col-md-2">
                                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id + accounts.account.first_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input"
                                                            :value="accounts.account_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                            readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                                class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="inputAddress">الحساب المقابل</label>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="custom-search" v-if="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.account_second_id">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input"
                                                            :value="accounts.id">
                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="custom-search" v-else>
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree'"
                                                            type="text" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_id'"
                                                            type="hidden" readonly class="custom-search-input">
                                                        <input style="background-color: beige;"
                                                            :id="'Structure_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                                        <button class="custom-search-botton" type="button"
                                                            data-toggle="modal"
                                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                                            <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>


                                            </div>


                                        </fieldset>

                                        <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                                        </button>

                                        <div v-for="(accounts, index) in list_data" :key="index" class="modal fade"
                                            :id="'exampleModal' + accounts.code" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="well" :id="'treeview_json_' + accounts.code"></div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div v-for="(accounts, index) in list_data" :key="index" class="modal fade"
                                            :id="'exampleModal' + accounts.code + accounts.type" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="well"
                                                            :id="'treeview_json_' + accounts.code + accounts.type">
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../../js/operation.js';

export default {

    mixins: [tree, operation],
    data() {
        return {
            list_data: '',

            account: [],
            code: [],
            type_account: [],
            count_accounts: '',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'Structure';
        this.list();



    },

    methods: {


        add_new_account() {

            this.axios
                .post(`/store_account_setting`, {
                    count: this.counts,
                    type: this.type,
                    name: this.account,
                    code: this.code,
                    type_account: this.type_account,

                }
                )
                .then((response) => {
                    console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });
        },
        submitForm() {

            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data
            let formData = new FormData();

            for (let index = 0; index < this.count_accounts; index++) {


                // alert(this.accounts.code);
                formData.append(`staff_${this.list_data[index].code}_account_id`,
                    $(`#Structure_${this.list_data[index].code}_tree_id`).val()
                    
                );
                formData.append(`staff_${this.list_data[index].code}_account_hraccount_id`, 
                    $(`#Structure_${this.list_data[index].code}_tree_hraccount_id`).val(),

                );
                formData.append(`staff_${this.list_data[index].code}_account_name`, [
                    $(`#Structure_${this.list_data[index].code}_tree`).val(),

                ]);

                // ----------------
                formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_id`, 
                    $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree_id`).val()
                );
                formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_hraccount_id`, 
                    $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree_hraccount_id`).val()

                );
                formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_name`, 
                    $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree`).val()

                );

            }

            // for (let index = 0; index < this.count_accounts; index++) {


            // alert(this.accounts.code);
            // formData.append(`staff_${this.list_data[index].code}_second_account_id`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree_id`).val());
            // formData.append(`staff_${this.list_data[index].code}_second_account_hraccount_id`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree_hraccount_id`).val());
            // formData.append(`staff_${this.list_data[index].code}_second_account_name`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree`).val());

            // }


            // send upload request
            this.axios
                .post("/store_staff_account_setting", formData, config)
                .then(function (response) {
                    console.log("hhhhhhhhhhhhhhhhhhhhhhh");
                    console.log(response);
                    currentObj.success = response.data.success;
                    currentObj.filename = "";

                    // e.preventDefault();
                    toastMessage("تم الاضافه بنجاح");
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(0);
        },

        list() {

            this.axios
                .post(`/get_staff_account_setting`)
                .then(({ data }) => {
                    console.log('muhibxcd', data.count_account);
                    this.list_data = data.accounts;
                    this.count_accounts = data.count_account;


                    for (let index = 0; index < this.count_accounts; index++) {

                        // console.log('reeeewwwppppwpppwpppwppwppwp', this.list_data[0].code);
                        // this.showtree(this.accounts.code);

                        this.showtree(this.list_data[index].code, 'tree_account');
                        this.showtree(this.list_data[index].code + this.list_data[index].type, 'tree_account');
                    }

                });




        },


    },
};
//
</script>
  
  