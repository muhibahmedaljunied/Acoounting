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
                            <select @change="get_time(period_selected)" id='select_period' v-model="period_selected"
                                name="type" class="form-control " required>

                            </select>
                        </div>

                        <div class="col-md-1">
                            <label> وقت الحضور</label>

                            <span id="start_period">

                                <input type="time" class="form-control" readonly>


                            </span>


                        </div>

                        <div class="col-md-1">
                            <label> وقت الانصراف</label>
                            <span id="end_period">
                                <input type="time" class="form-control" readonly>

                            </span>


                        </div>


                        <div class="col-md-2">
                            <label for="status"> الموظف</label>
                            <select id='select_staff' v-model="staff_search" name="type" class="form-control " required>

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




                                        </td>


                                        <td>
                                            <div v-if="check_attend[index] == 1" style="display: flex;">

                                                <!-- <div v-if="attendance_in_out == 1"> -->
                                                <label for="in" style="color:red">وقت الحضور</label>
                                        <td>
                                            <input type="time" v-if="attendance_in_out == 1" name="in" id=""
                                                v-model="check_in[index]">
                                            <input type="time" v-else name="in" id="" v-model="check_in[index]" readonly>

                                        </td>
                                        <!-- </div> -->

                                        <!-- <div v-if="attendance_in_out == 2"> -->
                                        <label for="out" style="color:red">وقت الانصراف</label>
                                        <td>
                                            <input type="time" v-if="attendance_in_out == 2" name="out" id=""
                                                v-model="check_out[index]">
                                            <input type="time" v-else name="out" id="" v-model="check_out[index]" readonly>

                                        </td>
                                        <!-- </div> -->



                        </div>
                        </td>
                        <td>
                            <!-- <input @keypress="calc_time(index)" name="duration" type="text" class="form-control"
                                id="duration"  readonly>

                            <input v-model="duration[index]" type="hidden" class="form-control" > -->


                            <input @keypress="calc_time(index)" type="text" class="form-control" name="name"
                                id="attendance_duration" readonly />
                            <input v-model="duration[index]" type="hidden" class="form-control" name="name">


                        </td>
                        <td>
                            <input v-model="delay[index]" id="attendance_delay" type="text" class="form-control" readonly>
                        </td>
                        <td>
                            <input v-model="leave[index]" id="attendance_leave" type="text" class="form-control" readonly>
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

// this API key for maps => AIzaSyAgDyMQ54mW-EHsTaFTnWd0XorOOvdDR34
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

            attendance_date: [],
            status: [],
            check_in: [],
            check_out: [],
            time_in: [],
            time_out: [],
            check_attend: [],
            duration: [],
            delay: [],
            leave: [],
            check_state: [],
            date: [],
            fieldset1: [],
            fieldset2: [],
            fieldset3: [],

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

            this.Add(
                {
                    type: this.type,
                    count: this.counts,
                    staff: this.staff_selected,
                    period: this.period_selected,
                    staff: this.staff,
                    attendance_date: this.date,
                    attendance_status: this.status,
                    time_in: this.check_in,
                    time_out: this.check_out,
                    duration: this.duration,
                    delay: this.delay,
                    leave: this.leave,
                    attendance_in_out: this.attendance_in_out,
                    work: this.work_selected,

                });


        },

        calc_time(index) {


            var split_in = this.check_in[index].split(":");
            var split_out = this.check_out[index].split(":");
            var date = this.attendance_date[index].split("-");

            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM
            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }
            var diff = date2 - date1;
            // 28800

            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;
            // diff = 28800000 => hh = 8, mm = 0, ss = 0, msec = 0

            console.log(hh, mm);
            // console.log(this.period_times[i].from_time);



            this.duration[index] = [hh, mm];
            $(`#attendance_duration`).val(`${hh}ساعه,${mm}دقيقه`);

            this.calc_delay(index);
            this.calc_leave(index);




            // ----------------------------------------------------------------------


        },
        calc_delay(index) {


            var split_in = this.period_times[0].from_time.split(":");
            var split_out = this.check_in[index].split(":");
            var date = this.attendance_date[index].split("-");
            // console.log(this.period_times[0].from_time.split(":"));


            console.log(split_in[0], split_in[1], split_out[0], split_out[1]);
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM

            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }
            var diff = date2 - date1;

            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            console.log(hh, mm);
            // console.log(this.period_times[i].from_time);

            $(`#attendance_delay`).val(`${hh}ساعه,${mm}دقيقه`);





        },
        calc_leave(index) {

            var split_in = this.period_times[0].into_time.split(":");
            var split_out = this.check_out[index].split(":");
            var date = this.attendance_date[index].split("-");


            // console.log(this.period_times[0].into_time);
            console.log(split_in[0], split_in[1], split_out[0], split_out[1]);
            var date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            var date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM
            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }
            var diff = date2 - date1;

            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            console.log(hh, mm);
            // console.log(this.period_times[i].into_time);

            $(`#attendance_leave`).val(`${hh}ساعه,${mm}دقيقه`);

        },
        get_time(period) {

            // console.log(period, this.period_times[0]);




            for (var i = 0; i < this.period_times.length; i++) {

                if (this.period_times[i].id == period) {

                    // <input type="number" name="" id="start_period" class="form-control" v-model="start_period_selected"> 

                    $(`#start_period`).html(`<input id='start_period_time'  value= ${this.period_times[i].from_time} class='form-control' readonly >`);
                    $(`#end_period`).html(`<input  id ='end_period_time' value= ${this.period_times[i].into_time} class='form-control'  readonly>`);

                }

            }




        },
        get_period(id) {


            axios.post(`/attendance/get_period/${id}`).then((response) => {


                console.log('muhib', response.data.periods);
                this.period_times = response.data.periods
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


        add_one_attendance(staff_id, check_attend, attendance_date, duration = 0, delay = 0, leave = 0, check_in, check_out, index) {
            console.log(staff_id);
            if (this.check_state[index] == true) {
                this.counts[index] = index;
                this.staff_selected[index] = staff_id;
                this.status[index] = check_attend;
                this.date[index] = attendance_date;
                this.duration[index] = duration;
                this.delay[index] = delay;
                this.leave[index] = leave;
                this.check_in[index] = check_in;
                this.check_out[index] = check_out;
            }
            else if (this.check_state[index] == false) {
                this.$delete(this.counts, index);
                // this.$delete(this.staff, index);
                // this.$delete(this.date, index);
                // this.$delete(this.status, index);
                // this.$delete(this.time_in, index);
                // this.$delete(this.time_out, index);

            }
            console.log(this.counts);
            console.log(this.staff_selected);
            console.log(this.date);
            console.log(this.duration);
            console.log(this.delay);
            console.log(this.leave);
            console.log(this.status);
            console.log(this.check_in);
            console.log(this.check_out);



        },
        check(e, index) {
            console.log(this.fieldset2[index]);
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
  
