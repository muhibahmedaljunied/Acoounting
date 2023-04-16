<template>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <span class="h2"> تحضير الموظف</span>
                    </div>

                </div>
                <div class="card-body" id="printme">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="status"> نوع التحضير</label>
                            <select v-model="attendance_in_out" class="form-control " required>
                                <option v-bind:value=1>
                                    دخول
                                </option>
                                <option v-bind:value=2>
                                    خروج
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status">نظام العمل</label>
                            <select v-model="work_selected" name="type" class="form-control " required
                                @change="get_period(work_selected)">
                                <option v-for="work_system in work_systems" v-bind:value="work_system.id">
                                    {{ work_system.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status"> الفتره</label>
                            <select id='select_period' v-model="period_selected" name="type" class="form-control " required>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status"> الموظف</label>
                            <select id='select_staff' v-model="staff_selected" name="type" class="form-control " required>

                            </select>
                        </div>


                        <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                            <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
                        </div>
                    </div>
                     <hr>
                    <!--<hr>
                    <hr> -->
                    <form action="post">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                        <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                        <th class="wd-10p border-bottom-0">الوظيفه</th>
                                        <th class="wd-10p border-bottom-0">التاريخ</th>
                                        <th class="wd-10p border-bottom-0">نوع الحضور</th>


                                        <th class="wd-10p border-bottom-0">الوقت</th>
                                        <th class="wd-10p border-bottom-0">عدد الساعات</th>
                                        <th class="wd-10p border-bottom-0">مده التأخير</th>
                                        <th class="wd-10p border-bottom-0">مده الانصراف قبل الدوام</th>
                                        <th>اضافه</th>

                                        <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="value_list && value_list.data.length > 0">
                                    <tr v-for="(staff, index) in value_list.data" :key="index">
                                        <!-- <td>{{ staff.id }}</td> -->

                                        <!-- <input v-model="staff_id = staff.id" type="hidden" name="name" id="name"
                                            class="form-control" /> -->
                                        <td>{{ staff.name }}</td>
                                        <td>{{ staff.job.text }}</td>
                                        <td>
                                            <input type="date" name="" id="" v-model="attendance_date[index]">
                                        </td>
                                        <td>

                                            <input type="checkbox" name='fieldset1' v-model="fieldset1[index]" id="apsence"
                                                @change="check($event, index)" />
                                            <label for="radio-example-one">غايب </label>

                                            <input type="checkbox" name='fieldset2' v-model="fieldset2[index]" id="attend"
                                                @change="check($event, index)" />
                                            <label for="radio-example-two">حاضر </label>

                                            <input type="checkbox" name='fieldset3' v-model="fieldset3[index]"
                                                id="permission" @change="check($event, index)" />
                                            <label for="radio-example-three">مستأذن</label>

                                            <!-- <input type="radio" name="fieldset-1" id="late" @change="check($event)" />
                                            <label for="radio-example-three">متأخر</label> -->





                                        </td>


                                        <td>
                                            <div v-if="check_attend[index] == 1" style="display: flex;">
                                                <div v-if="attendance_in_out == 1">
                                                    <!-- <label for="in">وقت الحضور</label> -->
                                        <td><input type="time" name="in" id="" v-model="check_in[index]"></td>
                        </div>

                        <div v-if="attendance_in_out == 2">
                            <!-- <label for="out">وقت الانصراف</label> -->
                            <td><input type="time" name="out" id="" v-model="check_out[index]"></td>
                        </div>



                </div>
                </td>
                <td>
                    <input v-model="duration[index]" type="number" class="form-control">
                </td>
                <td>
                    <input v-model="delay[index]" type="number" class="form-control">
                </td>
                <td>
                    <input v-model="leave[index]" type="number" class="form-control">
                </td>
                <td>

                    <input @change="
                        add_one_attendance(
                            staff.id,
                            check_attend[index],
                            attendance_date[index],
                            0,
                            0,
                            0,
                            check_in[index],
                            check_out[index],
                            index

                        )
                    " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />


                </td>



                </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td align="center" colspan="3">لايوجد بياتات.</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                    العمليه</span></a> -->
            </form>
            <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal-footer">
                <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                    العمليه</span></a>
              </div>

    </div>
    </div>
    </div>
</template>
  
<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/operation.js';

export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {

            value_list: {
                type: Object,
                default: null,
            },



        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {
        get_period(id) {


            axios.post(`/attendance/get_period/${id}`).then((response) => {


                // console.log('muhib',response.data.periods[0] );
                var arrayLength = response.data.periods.length
                var arrayLength2 = response.data.staffs.length
                var html = '';
                var html2 = '';


                for (var i = 0; i < arrayLength; i++) {
                    console.log('muhib', response.data.periods[i].name);

                    html = html + `<option data-period-${id}= ${response.data.periods[i].id}   value= ${response.data.periods[i].id} >${response.data.periods[i].name}</option>`

                }

                for (var i = 0; i < arrayLength2; i++) {
                    console.log('muhib', response.data.staffs[i].name);

                    html2 = html2 + `<option data-staff-${id}= ${response.data.staffs[i].id}   value= ${response.data.staffs[i].id} >${response.data.staffs[i].name}</option>`

                }


                $(`#select_period`).html(html);
                $(`#select_staff`).html(html2);


            });




        },
        // get_staff(id) {
        //     axios.post(`/attendance/get_staff/${id}`).then((response) => {

        //         // console.log('muhib',response.data.periods[0] );

        //         var arrayLength = response.data.periods.length
        //         var html = '';

        //         for (var i = 0; i < arrayLength; i++) {


        //             html = html + `<option data-period-${id}= ${response.data.staffs[i].id}   value= ${response.data.staffs[i].id} >${response.data.staffs[i].name}</option>`

        //         }


        //         $(`#select_staff`).html(html);



        //     });



        // },

        add_one_attendance(staff_id, check_attend, attendance_date, duration = 0, delay = 0, leave = 0, check_in, check_out, index) {
            console.log(staff_id);
            if (this.check_state[index] == true) {
                this.counts[index] = index;
                this.staff[index] = staff_id;
                this.status[index] = check_attend;
                this.date[index] = attendance_date;
                this.duration[index] = duration;
                this.delay[index] = delay;
                this.leave[index] = leave;
                this.time_in[index] = check_in;
                this.time_out[index] = check_out;
            }
            else if (this.check_state[index] == false) {
                this.$delete(this.counts, index);
                // this.$delete(this.staff, index);
                // this.$delete(this.date, index);
                // this.$delete(this.status, index);
                // this.$delete(this.time_in, index);
                // this.$delete(this.time_out, index);

            }
            // console.log(this.counts);
            // console.log(this.staff);
            // console.log(this.date);
            // console.log(this.duration);
            // console.log(this.delay);
            // console.log(this.leave);
            // console.log(this.status);
            // console.log(this.time_in);
            // console.log(this.time_out);



        },
        check(e, index) {
            if (this.fieldset2[index] == true) {

                if (e.target.id == 'attend') {
                    this.check_attend[index] = 1;
                    this.attendance_status = 1
                }

            } else {

                if (e.target.id == 'apsence') {
                    this.check_attend[index] = 0;
                    this.attendance_status = 0
                }

                if (e.target.id == 'permission') {
                    this.check_attend[index] = 2;
                    this.attendance_status = 2
                }



            }


        },

        get_search(word_search) {
            this.axios
                .post(`/staffsearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    this.staffs = data.staffs;

                    // this.$root.logo = "Category";
                });
        },

        list(page = 1) {
            this.axios
                .post(`/staff?page=${page}`)
                .then(({ data }) => {
                    this.value_list = data.list;
                    this.work_systems = data.work_systems;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },



    },
};
</script>
  
