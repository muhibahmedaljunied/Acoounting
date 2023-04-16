<template>
    <div class="page-wrapper">
        <div>


            <h2>الحضور والغياب</h2>
        </div>
        <div class="content container-fluid">



            <!-- Search Filter -->
            <div class="row filter-row">


                <div class="col-sm-6 col-md-3">

                    <label class="focus-label">الموظف</label>
                    <select @change="select_staff" v-model="staff_selected" name="type" id="type"
                        class="select floating form-control " required>
                        <option>-</option>
                        <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                        </option>
                    </select>

                </div>


                <div class="col-sm-6 col-md-3">
                    <label class="focus-label">الشهر</label>

                    <select v-model="month_selected" class="select floating form-control">
                        <option>-</option>
                        <option v-bind:value="1">Jan</option>
                        <option v-bind:value="2">Feb</option>
                        <option v-bind:value="3">Mar</option>
                        <option v-bind:value="4">Apr</option>
                        <option v-bind:value="5">May</option>
                        <option v-bind:value="6">Jun</option>
                        <option v-bind:value="7">Jul</option>
                        <option v-bind:value="8">Aug</option>
                        <option v-bind:value="9">Sep</option>
                        <option v-bind:value="10">Oct</option>
                        <option v-bind:value="11">Nov</option>
                        <option v-bind:value="12">Dec</option>
                    </select>

                </div>
                <div class="col-sm-6 col-md-3">
                    <label class="focus-label">السنه</label>
                    <select v-model="year_selected" class="select floating form-control">
                        <option>-</option>
                        <option v-bind:value="9">2023</option>
                        <option v-bind:value="8">2022</option>
                        <option v-bind:value="7">2021</option>
                        <option v-bind:value="6">2020</option>
                        <option v-bind:value="5">2019</option>
                        <option v-bind:value="4">2018</option>
                        <option v-bind:value="3">2017</option>
                        <option v-bind:value="2">2016</option>
                        <option v-bind:value="1">2015</option>
                    </select>

                </div>
                <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                    <a href="#" @click="search()"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
                </div>


            </div>
            <hr>
            <hr>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr id="name_day">
                                    <!-- <th>الموظف</th>
                                    <th v-for="days in number_of_days">{{days}}</th>
                                    -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(attendance, index) in list_data.data" :key="index">
                                    <td>
                                        <h5 class="table-avatar">
                                            <!-- <a class="avatar avatar-xs"><img alt="" src="assets/img/ecommerce/01.jpg"></a> -->
                                            <a>{{ attendance.name }}</a>
                                        </h5>
                                    </td>

                                    <td v-for="attends in attendance.attendance">

                                        <a class="btn btn-info" v-if="attends.attendance_status == 1"
                                            href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info">P
                                        </a>

                                        <a class="btn btn-danger" v-if="attends.attendance_status == 0"
                                            href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info">A
                                        </a>


                                        <a class="btn btn-warning" v-if="attends.attendance_status == 2"
                                            href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info">H
                                        </a>
                                    </td>



                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination>

                </div>
            </div>
        </div>
    </div>
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
            start_date: "",
            end_date: "",
            days: 2,
            name: "",
            table: 'attendance',
            staffs: "",
            jobselected: 1,
            branchselected: 1,
            staff_typeselected: 1,
            vacation_typeselected: 1,
            staffselected: 1,
         
            staff_on_change: "",
            vactions: "",
            jobs: "",
            branches: "",
            staff_types: "",
            vacation_types: "",
            word_search: "",
        };
    },
    mounted() {
        this.list();

        // var days = function (month, year) {
        //     return new Date(year, month, 0).getDate();
        // };
        // console.log("Days in July: " + days(7, 2012)); // July month
        // console.log("<br>Days in September: " + days(9, 2012)); // September Month


        // // -----------------

        // const date_str = "07/20/2021";
        // const date = new Date(date_str);
        // const full_day_name = date.toLocaleDateString('default', { weekday: 'long' });
        // // -> to get full day name e.g. Tuesday
        // console.log(full_day_name);
        // const short_day_name = date.toLocaleDateString('default', { weekday: 'short' });
        // console.log(short_day_name);
        // -> TO get the short day name e.g. Tue

    },
    methods: {

        search() {

            // axios.post(`/attendance/get_period/${id}`).then((response) => {

            //     var arrayLength = response.data.attendance.length


             this.get_day_name();

            // });



        },
        get_day_name() {

            var date_obj =new Date();
            
            var month =   date_obj.getMonth();
            var year =   date_obj.getFullYear();

            var html_head = `<th>الموظف</th>`;



            for (var i = 1; i <= new Date(year, month, 0).getDate(); i++) {


                const date_str = `${month}/${i}/${year}`
                const date = new Date(date_str);
                const full_day_name = date.toLocaleDateString('default', { weekday: 'short' });

                if (full_day_name == 'Fri') {
                    html_head = html_head + `<th>
                                                <span>${i}</span> <hr> 
                                                <span style='color:red'>${full_day_name}</span>
                                                     
                                            </th>`
                } else {
                    html_head = html_head + `<th>
                                                <span>${i}</span> <hr> 
                                                <span>${full_day_name}</span>
                                                     
                                            </th>`
                }


            }
            $(`#name_day`).html(html_head);

        },
        list(page = 1) {

          this.get_day_name();
            this.axios
                .post(`/attendance?page=${page}`)
                .then(({ data }) => {
                    console.log(data.attendance)
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

