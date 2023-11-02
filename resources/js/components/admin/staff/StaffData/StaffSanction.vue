<template>
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

                    <span class="h2"> جزاءات الموظف</span>

                </div>
                <div class="card-body" id="printme">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="status">اسم الموظف</label>
                            <select @change="select_staff" v-model="staff_selected" name="type" id="type"
                                class="form-control " required>
                                <option v-for="staff in staffs" v-bind:value="staff.id">
                                    {{ staff.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status"> نوع الجزاء</label>
                            <select v-model="sanction_selected" name="type" id="type" class="form-control " required>
                                <option v-bind:value=1>
                                    غياب
                                </option>
                                <option v-bind:value=2>
                                    تأخير
                                </option>
                                <option v-bind:value=3>
                                    انصراف مبكر
                                </option>
                                <!-- <option v-bind:value=4>
                                    اضافي
                                </option> -->
                            </select>

                        </div>


                        <div class="col-md-2">
                            <label for="status">الشهر</label>

                            <select @change="select_staff" v-model="staff_selected" name="type" id="type"
                                class="form-control " required>
                                <option v-for="staff in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]">
                                    {{ staff }}
                                </option>
                            </select>

                        </div>
                        <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                            <a href="#" @click="search(sanction_selected)"><img src="/assets/img/search.png" alt=""
                                    style="width: 10%;"> </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                                    <th class="wd-15p border-bottom-0">نوع الجراء</th>

                                    <th class="wd-15p border-bottom-0">التاريخ</th>
                                    <th class="wd-15p border-bottom-0">البند</th>
                                    <th class="wd-15p border-bottom-0">الوقت</th>
                                    <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>

                                    <th class="wd-15p border-bottom-0">الخصم</th>
                                    <!-- <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th> -->

                                    <th class="wd-15p border-bottom-0"> الحاله</th>


                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody v-if="list_data && list_data.data.length > 0">
                                <tr v-for="(advance, index) in list_data.data" :key="index">
                                    <template
                                        v-if="advance.LeaveSanction || advance.DelaySanction || advance.ExtraSanction || advance.ExtraDetails">

                                        <td>{{ advance.name }}</td>
                                        <td>

                                            {{ advance.type }}

                                        </td>
                                        <td>



                                            {{ advance.sanction_date }}

                                        </td>
                                        <template v-if="advance.DelaySanction">

                                            <td>

                                                <div v-for="(adv, index) in advance.DelaySanction" :key="index">
                                                    {{ adv.name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.DelaySanction" :key="index">
                                                    {{ adv.parts_name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.DelaySanction" :key="index">
                                                    {{ adv.iteration }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.DelaySanction" :key="index">
                                                    {{ adv.sanction }}
                                                    <hr>
                                                </div>
                                            </td>

                                        </template>

                                        <template v-if="advance.LeaveSanction">
                                            <!-- <td>

                                                <div v-for="(adv, index) in advance.LeaveSanction" :key="index">
                                                    {{ adv.created_at }}
                                                    <hr>
                                                </div>
                                            </td> -->
                                            <td>

                                                <div v-for="(adv, index) in advance.LeaveSanction" :key="index">
                                                    {{ adv.name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.LeaveSanction" :key="index">
                                                    {{ adv.parts_name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.LeaveSanction" :key="index">
                                                    {{ adv.iteration }}
                                                    <hr>
                                                </div>
                                            </td>

                                            <td>

                                                <div v-for="(adv, index) in advance.LeaveSanction" :key="index">
                                                    {{ adv.sanction }}
                                                    <hr>
                                                </div>
                                            </td>

                                        </template>


                                        <template v-if="advance.ExtraSanction">

                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraSanction" :key="index">
                                                    {{ adv.name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraSanction" :key="index">
                                                    {{ adv.iteration }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraSanction" :key="index">
                                                    {{ adv.sanction }}
                                                    <hr>
                                                </div>
                                            </td>

                                        </template>


                                        <template v-if="advance.ExtraDetails">

                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraDetails" :key="index">
                                                    {{ adv.name }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraDetails" :key="index">
                                                    {{ adv.iteration }}
                                                    <hr>
                                                </div>
                                            </td>
                                            <td>

                                                <div v-for="(adv, index) in advance.ExtraDetails" :key="index">
                                                    {{ adv.sanction }}
                                                    <hr>
                                                </div>
                                            </td>

                                        </template>






                               

                                        <td style="color:goldenrod">
                                            <span class="badge text-bg-warning">غير معتمد</span>

                                        </td>
                                        <td style="color:goldenrod">

                                        </td>


                                    </template>

                                </tr>
                                <tr>
                                    <td colspan="3" style="color:red;font-size: x-large;">الاجمالي</td>

                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">لايوجد بياتات.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="advances" @pagination-change-page="list"></pagination>
                </div>
               -->
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
</template>
  
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/StaffData/staff_data.js';

export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {
            // category: "yes",

            list_data: {
                type: Object,
                default: null,
            },
            staff_selected: 1,
            count: 1,
            counts: [],
            quantity: [],
            date: [],
            staffselected: [],
            sanction_selected: '',
            quantityselected: '',

            table: 'advance',

            staffs: '',
            note: '',

        };
    },
    mounted() {
        this.list();
        this.counts[0] = 1;
        this.type = 'advance';
    },
    methods: {

        //   7423      
        search() {
            this.axios
                .post(`/staff_sanction_report`, { value_search: this.sanction_selected })
                .then(({ data }) => {
                    console.log(data.list);
                    this.list_data = data.list;

                });
        },

        list(page = 1) {
            this.axios
                .post(`/staff_sanction?page=${page}`)
                .then(({ data }) => {
                    this.list_data = data.list;
                    this.staffs = data.staffs;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },





    },
};
</script>
  
  