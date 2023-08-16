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
                        <div class="col-md-1">
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
                        <div class="col-md-1">
                            <label for="status">نظام العمل</label>
                            <select v-model="work_selected" name="type" class="form-control " required
                                @change="get_period(work_selected)">
                                <option v-for="work_system in work_systems" v-bind:value="work_system.id">
                                    {{ work_system.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="status"> الفتره</label>
                            <select @change="get_time(period_selected)" id='select_period' v-model="period_selected"
                                name="type" class="form-control " required>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="status"> التأريخ</label>
                            <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                        </div>




                        <div class="col-md-2">
                            <label> وقت الحضور</label>

                            <span id="start_period">

                                <input type="time" class="form-control">


                            </span>


                        </div>

                        <div class="col-md-2">
                            <label> وقت الانصراف</label>
                            <span id="end_period">
                                <input type="time" class="form-control">

                            </span>


                        </div>




                        <div class="col-md-1">
                            <label for="status"> الموظف</label>
                            <select id='select_staff' v-model="staff_search" name="type" class="form-control " required>

                            </select>
                        </div>


                        <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                            <!-- <a href="#" onclick="get_time_for_all_staff(period_selected)"><img src="/assets/img/search.png"
                                    alt="" style="width: 15%;"> </a> -->

                            <a @click="get_time_for_all_staff(period_selected)" id="agregar_productos"
                                data-target=".bs-example-modal-sm">
                                <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
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
                                        <!-- <th class="wd-10p border-bottom-0">الوظيفه</th> -->
                                        <!-- <th class="wd-10p border-bottom-0">التاريخ</th> -->
                                        <th class="wd-10p border-bottom-0">نوع الحضور</th>


                                        <th class="wd-10p border-bottom-0">الوقت</th>
                                        <th class="wd-10p border-bottom-0">عدد الساعات</th>
                                        <th class="wd-10p border-bottom-0">مده التأخير</th>
                                        <th class="wd-10p border-bottom-0"> الانصراف قبل الدوام</th>
                                        <th class="wd-10p border-bottom-0"> الاضافي</th>

                                        <th>اضافه</th>

                                        <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="value_list && value_list.data.length > 0">
                                    <tr v-for="(staff, indexs) in value_list.data" :key="indexs">
                                        <!-- <td>{{ staff.id }}</td> -->

                                        <!-- <input v-model="staff_id = staff.id" type="hidden" name="name" id="name"
                                            class="form-control" /> -->
                                        <td>{{ staff.name }}</td>
                                        <!-- <td>{{ staff.job.text }}</td> -->
                                        <!-- <td>
                                            <input type="date" name="" id="" v-model="attendance_date[index]">
                                        </td> -->
                                        <td>

                                            <input v-if="staff.attendance_status == 0" type="checkbox" name='fieldset1'
                                                v-bind:id='"absence" + indexs' @change="check($event, indexs)" checked />
                                            <input v-else type="checkbox" name='fieldset1' v-bind:id='"absence" + indexs'
                                                @change="check($event, indexs)" />

                                            <label for="radio-example-one">غايب </label>

                                            <input v-if="staff.attendance_status == 1" type="checkbox" name='fieldset1'
                                                v-bind:id='"attend" + indexs' @change="check($event, indexs)" checked />
                                            <input v-else type="checkbox" name='fieldset1' v-bind:id='"attend" + indexs'
                                                @change="check($event, indexs)" />

                                            <label for="radio-example-two">حاضر </label>




                                        </td>

                                        <template v-if="staff.details">


                                            <div v-for="details in staff.details" style="display: flex;">



                                                <td>
                                                    <label for="in" style="color:red"> حضور</label>
                                                    <input type="time" name="in" v-bind:id='"in" + indexs'
                                                        :value="details.check_in">



                                                </td>


                                                <td>
                                                    <label for="out" style="color:red"> انصراف</label>
                                                    <input v-if="staff.attendance_final == 'complete'" type="time"
                                                        name="out" v-bind:id='"out" + indexs' :value="details.check_out">
                                                    <input v-else type="time" name="out" v-bind:id='"out" + indexs'>


                                                </td>






                                            </div>


                                            <td v-for="details_duration in staff.details">


                                                <input @keypress="calc_time(indexs)" type="text" class="form-control"
                                                    name="name" v-bind:id='"attendance_duration" + indexs' :value=0 />
                                                <input v-bind:id='"attendance_duration_hidden" + indexs' type="hidden"
                                                    class="form-control" name="name" :value="details_duration.duration">


                                            </td>
                                            <td v-for="details_delay in staff.details">
                                                <input v-bind:id='"attendance_delay" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input type="hidden" v-bind:id='"attendance_delay_hidden" + indexs'
                                                    class="form-control" name="name" :value="details_delay.delay">

                                            </td>
                                            <td v-for="details_leave in staff.details">
                                                <input v-bind:id='"attendance_leave" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input type="hidden" v-bind:id='"attendance_leave_hidden" + indexs'
                                                    class="form-control" readonly :value="details_leave.leave">

                                            </td>
                                            <td v-for="details_extra in staff.details">
                                                <input v-bind:id='"attendance_extra" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input v-bind:id='"attendance_extra_hidden" + indexs' type="hidden"
                                                    class="form-control" readonly :value="details_extra.extra">

                                            </td>




                                        </template>

                                        <template v-else>
                                            <div style="display: flex;">



                                                <td>
                                                    <label for="in" style="color:red"> حضور</label>
                                                    <input type="time" name="in" v-bind:id='"in" + indexs' :value=0>


                                                </td>


                                                <td>
                                                    <label for="out" style="color:red"> انصراف</label>
                                                    <input type="time" name="out" v-bind:id='"out" + indexs' :value=0>


                                                </td>






                                            </div>

                                            <td>


                                                <input @keypress="calc_time(indexs)" type="text" class="form-control"
                                                    name="name" v-bind:id='"attendance_duration" + indexs' :value=0 />
                                                <input v-bind:id='"attendance_duration_hidden" + indexs' type="hidden"
                                                    class="form-control" name="name">


                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_delay" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input type="hidden" v-bind:id='"attendance_delay_hidden" + indexs'
                                                    class="form-control" name="name">

                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_leave" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input type="hidden" v-bind:id='"attendance_leave_hidden" + indexs'
                                                    class="form-control" readonly>

                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_extra" + indexs' type="text"
                                                    class="form-control" :value=0>
                                                <input v-bind:id='"attendance_extra_hidden" + indexs' type="hidden"
                                                    class="form-control">

                                            </td>
                                        </template>


                                        <td>

                                            <input @change="
                                                add_one_attendance(
                                                    staff.staff_id,
                                                    staff.attendance_status,
                                                    indexs

                                                )
                                                " type="checkbox" v-model="check_state[indexs]"
                                                class="btn btn-info waves-effect" />


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
import operation from '../../../../../js/staff/operation/operation.js';

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

            attendance_date: new Date().toISOString().substr(0, 10),
            attendance_final: 'pendding',
            show: true,
            // attendance_date:0,
            status: [],
            check_in: [],
            check_out: [],
            time_in: [],
            time_out: [],
            check_attend: [],
            duration: [],
            delay: [],
            leave: [],
            extra: [],
            check_state: [],
            date: [],
            fieldset1: [],
            fieldset2: [],
            fieldset3: [],
            staff: [],

            staff_search: '',
            attendance_in_out: '',
            work_selected: '',
            period_selected: '',
            period_times: '',



        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {

        Add_new() {

            var type = this.get_type_of_leave_delay();

            this.axios
                .post(`/store_attendance`, {
                    type: this.type,
                    count: this.counts,
                    staff: this.staff,
                    period: this.period_selected,
                    staff: this.staff,
                    attendance_date: this.attendance_date,
                    attendance_final: this.attendance_final,
                    attendance_status: this.status,
                    time_in: this.check_in,
                    time_out: this.check_out,
                    duration: this.duration,
                    delay: this.delay,
                    leave: this.leave,
                    extra: this.extra,
                    type_leave_delay: type,

                    attendance_in_out: this.attendance_in_out,
                    work: this.work_selected,

                })
                .then((response) => {
                    console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });




        },
        get_type_of_leave_delay() {

            var split_in = this.attendance_date.split("-");

            var date_obj = new Date();
            var month = split_in[1];
            var day = split_in[2];
            // alert(month);
            var year = date_obj.getFullYear();

            const date_str = `${month}/${day}/${year}`
            const date = new Date(date_str);
            const full_day_name = date.toLocaleDateString('default', { weekday: 'short' });
          

            return full_day_name;




        },
        calc_time(index) {

            var time, mm, hh;
           
            if ($(`#in${index}`).val() && $(`#out${index}`).val()) {

                this.attendance_final = 'complete';
            } else {

                return 0;
            }




            this.check_in[index] = $(`#in${index}`).val();
            this.check_out[index] = $(`#out${index}`).val();


            console.log('----------', split_in, split_out);

            var split_in = this.check_in[index].split(":");
            var split_out = this.check_out[index].split(":");

            var date = this.attendance_date.split("-");
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM
       
            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }

            [time, mm, hh] = this.get_diff(date1, date2);


            // ------------------------------------------------------------------------------------

            this.duration[index] = time;
            $(`#attendance_duration${index}`).val(`${hh}ساعه,${mm}دقيقه`);
            $(`#attendance_duration_hidden${index}`).val(mm + (hh * 60));
            this.calc_delay(index);
            this.calc_extra(index);
            this.calc_leave(index);


        },

        calc_delay(index) {

            var time, mm, hh;
            var date1, date2;
            for (let i = 0; i < this.period_times.length; i++) {

                if (this.period_times[i].period_id == this.period_selected) {

                    var split_in = this.period_times[i].from_time.split(":");
                    var split_out = this.check_in[index].split(":");

                }

            }
            var date = this.attendance_date.split("-");
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM

            // --------------------------------------------------------------------------------------------

            if (date2 < date1) {

                [time, mm, hh] = this.get_diff(date2, date1);

               

                $(`#attendance_delay${index}`).val(`${0}ساعه,${0}دقيقه`);
                $(`#attendance_delay_hidden${index}`).val(0);



            } else {

                [time, mm, hh] = this.get_diff(date1, date2);

                this.delay[index] = time;
                $(`#attendance_delay${index}`).val(`${hh}ساعه,${mm}دقيقه`);
                $(`#attendance_delay_hidden${index}`).val(time);



            }

        },
        calc_extra(index){

            
            var time, mm, hh;
            var date1, date2;
            for (let i = 0; i < this.period_times.length; i++) {

                if (this.period_times[i].period_id == this.period_selected) {

                    var split_in = this.period_times[i].from_time.split(":");
                    var split_out = this.check_in[index].split(":");

                }

            }
            var date = this.attendance_date.split("-");
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM

            // --------------------------------------------------------------------------------------------

            if (date2 < date1) {

                [time, mm, hh] = this.get_diff(date2, date1);

                this.extra[index] = time;
                $(`#attendance_extra${index}`).val(`${hh}ساعه,${mm}دقيقه`);
                $(`#attendance_extra_hidden${index}`).val(time);
       

            } else {

                [time, mm, hh] = this.get_diff(date1, date2);

                this.extra[index] = 0;
                $(`#attendance_extra${index}`).val(`${0}ساعه,${0}دقيقه`);
                $(`#attendance_extra_hidden${index}`).val(0);



            }

        },
        calc_leave(index) {
            var time, mm, hh;
            var date1, date2;
            for (let i = 0; i < this.period_times.length; i++) {

                if (this.period_times[i].period_id == this.period_selected) {

                    var split_in = this.period_times[i].into_time.split(":");
                    var split_out = this.check_out[index].split(":");

                }

            }


            var date = this.attendance_date.split("-");
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM



   
            [time, mm, hh] = this.get_diff(date2, date1);


            this.leave[index] = time;

            $(`#attendance_leave${index}`).val(`${hh}ساعه,${mm}دقيقه`);
            $(`#attendance_leave_hidden${index}`).val(time);
        },

        get_date() {

            var date = this.attendance_date.split("-");
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM


            return [date1, date2];
        },
        get_diff(date1, date2) {

            var diff = date2 - date1;


            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            var time = mm + (hh * 60);

            if (mm == 0) {
                time = (hh * 60)
            }
            if (hh == 0) {
                time = mm
            }


            return [time, mm, hh]


        },
        get_time(period) {



            for (var i = 0; i < this.period_times.length; i++) {


                if (this.period_times[i].period_id == period) {

                    $(`#start_period`).html(`<input id='start_period_time' type='time'  value= ${this.period_times[i].from_time} class='form-control' readonly >`);
                    $(`#end_period`).html(`<input  id ='end_period_time' type='time' value= ${this.period_times[i].into_time} class='form-control'  readonly>`);

                }

            }


        },
        get_time_for_all_staff(id) {

            axios.post(`/attendance/get_time/${id}`, { date: this.attendance_date }).then( //get_time_for_current_period
                (response) => {

                    this.value_list = response.data.periods;
                    console.log(this.value_list);

                    // var arrayLength = response.data.periods.length
                    // for (var i = 0; i < arrayLength; i++) {
                    //     console.log('muhib', response.data.periods[i]);
                    //     if (response.data.periods[i].attendance_status == 0) {


                    //         document.getElementById(`absence${i}`).setAttribute('checked', 'checked');
                    //         document.getElementById(`attend${i}`).removeAttribute('checked');
                    //         this.show = false;


                    //     }
                    //     else {
                    //         var arrayLengthdetails = response.data.periods[i].details.length
                    //         var details = 0;
                    //         console.log('muhib2', arrayLengthdetails);
                    //         this.show = true;

                    //         for (var ii = 0; ii < arrayLengthdetails; ii++) {

                    //             details = response.data.periods[i].details[ii];
                    //             console.log('muhib', response.data.periods[i].details[ii]);

                    //             $(`#in${i}`).val(details.check_in);
                    //             if (response.data.periods[i].attendance_final == 'complete') {
                    //                 $(`#out${i}`).val(details.check_out);
                    //             }

                    //             document.getElementById(`attend${i}`).setAttribute('checked', 'checked');
                    //             document.getElementById(`absence${i}`).removeAttribute('checked');
                    //             // -----------------------------------------------
                    //             this.translate_time(details, i, ii);
                    //             // -----------------------------------------------
                    //             $(`#attendance_duration_hidden${i}`).val(details.duration);
                    //             $(`#attendance_delay_hidden${i}`).val(details.delay);
                    //             $(`#attendance_leave_hidden${i}`).val(details.leave);
                    //             $(`#attendance_extra_hidden${i}`).val(details.extra);
                    //         }
                    //     }

                    // }



                });
        },
        translate_time(response, i) {

            var time = [];

            if (response.duration / 60 >= 1) {


                time[0] = Math.floor(response.duration / 60) + 'ساعه';
            }
            if (response.duration % 60 >= 1) {
                time[1] = Math.floor(response.duration % 60) + 'دقيقه';
            }
            console.log(`attendance_duration${i}`, time);
            $(`#attendance_duration${i}`).val(time);
            time = [0, 0];
            // ---------------------------------------------------------------
            if (response.delay / 60 >= 1) {


                time[0] = Math.floor(response.delay / 60) + 'ساعه';
            }
            if (response.delay % 60 >= 1) {
                time[1] = Math.floor(response.delay % 60) + 'دقيقه';
            }
            console.log(`attendance_delay${i}`, time);
            $(`#attendance_delay${i}`).val(time);
            time = [0, 0];
            // ------------------------------------------------------------------------
            if (response.leave / 60 >= 1) {


                time[0] = Math.floor(response.leave / 60) + 'ساعه';
            }
            if (response.leave % 60 >= 1) {
                time[1] = Math.floor(response.leave % 60) + 'دقيقه';
            }
            console.log(`attendance_leave${i}`, time);
            $(`#attendance_leave${i}`).val(time);
            time = [0, 0];
            // ----------------------------------------------------------------------------
            if (response.extra / 60 >= 1) {


                time[0] = Math.floor(response.extra / 60) + 'ساعه';
            }
            if (response.extra % 60 >= 1) {

                time[1] = Math.floor(response.extra % 60) + 'دقيقه';
            }
            console.log(`attendance_extra${i}`, time);
            $(`#attendance_extra${i}`).val(time);
            time = [0, 0];

            // ----------------------

        },
        get_period(id) {

            // alert(id);
            axios.post(`/attendance/get_period/${id}`).then((response) => {


                console.log('muhib', response.data.periods);
                this.period_times = response.data.periods
                var arrayLength = response.data.periods.length
                var arrayLength2 = response.data.staffs.length
                var html = '';
                var html2 = '';


                for (var i = 0; i < arrayLength; i++) {
                    // console.log('muhib', response.data.periods[i].name);

                    html = html + `<option data-period-${id}= ${response.data.periods[i].period_id}   value= ${response.data.periods[i].period_id} >${response.data.periods[i].period_name}</option>`

                }

                for (var i = 0; i < arrayLength2; i++) {
                    console.log('muhib', response.data.staffs[i].name);

                    html2 = html2 + `<option data-staff-${id}= ${response.data.staffs[i].id}   value= ${response.data.staffs[i].id} >${response.data.staffs[i].name}</option>`

                }

                $(`#select_period`).html(html);
                $(`#select_staff`).html(html2);


            });




        },


        add_one_attendance(staff_id, attendance_status, index) {

            // console.log(this.check_attend[index]);
            if (this.check_state[index] == true) {
                this.counts[index] = index;
                this.staff[index] = staff_id;
                // this.status[index] = this.check_attend[index];
                this.status[index] = attendance_status;

                this.duration[index] = $(`#attendance_duration_hidden${index}`).val();
                this.delay[index] = $(`#attendance_delay_hidden${index}`).val();
                this.leave[index] = $(`#attendance_leave_hidden${index}`).val();
                this.extra[index] = $(`#attendance_extra_hidden${index}`).val();
                this.check_in[index] = $(`#in${index}`).val();
                this.check_out[index] = $(`#out${index}`).val();
            }
            else if (this.check_state[index] == false) {
                this.$delete(this.counts[index], index);


            }
            console.log(this.counts);
            console.log(this.staff, 'staff');
            console.log(this.duration);
            console.log(this.delay);
            console.log(this.leave);
            console.log(this.status);
            console.log(this.check_in);
            console.log(this.check_out);



        },
        // check(e, index) {


        //     if (e.target.id == `attend${index}`) {
        //         this.check_attend[index] = 1;
        //         // document.getElementById(`absence${index}`).removeAttribute('checked');




        //     }
        //     if (e.target.id == `absence${index}`) {

        //         this.check_attend[index] = 0;
        //         // document.getElementById(`attend${index}`).removeAttribute('checked');

        //     }




        // },

        get_search(word_search) {
            this.axios
                .post(`/staffsearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    this.staffs = data.staffs;


                });
        },

        list(page = 1) {
            this.axios
                .post(`/staff?page=${page}`, { type: 'attendance' })
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
  
