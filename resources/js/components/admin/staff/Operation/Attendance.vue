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
                    <form action="post" @submit.prevent="submitForm">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                        <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                                        <th class="wd-15p border-bottom-0">الوظيفه</th>
                                        <th class="wd-15p border-bottom-0">نوع الحضور</th>

                                        <th class="wd-15p border-bottom-0">التاريخ</th>
                                        <th class="wd-15p border-bottom-0">الوقت</th>
                                        <th>اضافه</th>

                                        <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="staffs && staffs.data.length > 0">
                                    <tr v-for="(staff, index) in staffs.data" :key="index">
                                        <!-- <td>{{ staff.id }}</td> -->

                                        <input v-model="staff_id = staff.id" type="hidden" name="name" id="name"
                                            class="form-control" />
                                        <td>{{ staff.staff }}</td>
                                        <td>{{ staff.job }}</td>
                                        <td>

                                            <input type="checkbox" name='fieldset1' v-model="fieldset1[index]"
                                                id="apsence" @change="check($event, index)" />
                                            <label for="radio-example-one">غايب </label>

                                            <input type="checkbox" name='fieldset2' v-model="fieldset2[index]"
                                                id="attend" @change="check($event, index)" />
                                            <label for="radio-example-two">حاضر </label>

                                            <input type="checkbox" name='fieldset3' v-model="fieldset3[index]"
                                                id="permission" @change="check($event, index)" />
                                            <label for="radio-example-three">مستأذن</label>

                                            <!-- <input type="radio" name="fieldset-1" id="late" @change="check($event)" />
                                            <label for="radio-example-three">متأخر</label> -->





                                        </td>
                                        <td>
                                            <input type="date" name="" id="" v-model="attendance_date[index]">
                                        </td>

                                        <td>
                                            <div v-if="check_attend[index] == 'attend'">
                                                <label for="in">وقت الحضور</label>
                                        <td><input type="time" name="in" id="" v-model="check_in[index]"></td>
                                        <label for="out">وقت الانصراف</label>
                                        <td><input type="time" name="out" id="" v-model="check_out[index]"></td>
                        </div>

                        <td>

                            <input @change="
                                add_one_attendance(
                                    staff.id,
                                    check_attend[index],
                                    attendance_date[index],
                                    check_in[index],
                                    check_out[index],
                                    index
                            
                                )
                            " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />


                        </td>


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
                <a href="javascript:void" @click="Add_newattendance()" class="btn btn-success"><span>تاكيد
                        العمليه</span></a>
                </form>
                <!-- <pagination align="center" :data="staffs" @pagination-change-page="list"></pagination> -->
            </div>

        </div>
    </div>
    </div>
</template>
  
<script>
import pagination from "laravel-vue-pagination";

export default {
    components: {
        pagination,
    },

    data() {
        return {
            type: '',
            counts: [],
            staff: [],
            status: [],
            time_in: [],
            time_out: [],
            check_state: [],
            fieldset1: [],
            fieldset2: [],
            fieldset3: [],
            date: [],
            staff_id: '',
            attendance_date: [],
            attendance_status: '',
            check_in: [],
            check_out: [],
            staffs: {
                type: Object,
                default: null,
            },
            check_attend: [],
            card: 234242424,
            email: "muhib@gmail.com",
            name: "fsdfsfsf",

            barth_date: "asdadad",
            phone: 1231313,
            social_statusselected: 1,
            genderselected: 1,
            statusselected: 1,
            staffselected: "adadad",
            staff_statusselected: 1,
            jobselected: 1,
            qualificationselected: 1,
            nationalityselected: 1,
            religionselected: 1,
            staff_typeselected: 1,
            registerselected: 1,
            branchselected: 1,
            departmentselected: 1,

            registers: "",
            branches: "",
            departments: "",
            qualifications: "",
            jobs: "",
            nationalities: "",
            religions: "",
            staff_types: "",

            word_search: "",
        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {
        add_one_attendance(staff_id, check_attend, attendance_date, check_in, check_out, index) {
            console.log(staff_id);
            if (this.check_state[index] == true) {
                this.counts[index] = index;
                this.staff[index] = staff_id;
                this.status[index] = check_attend;
                this.date[index] = attendance_date;
                this.time_in[index] = check_in;
                this.time_out[index] = check_out;
            }
            else if (this.check_state[index] == false) {
                this.$delete(this.counts, index);
                this.$delete(this.staff, index);
                this.$delete(this.date, index);
                this.$delete(this.status, index);
                this.$delete(this.time_in, index);
                this.$delete(this.time_out, index);

            }
            console.log(this.counts);
            console.log(this.staff);
            console.log(this.date);
            console.log(this.status);
            console.log(this.time_in);
            console.log(this.time_out);



        },
        check(e, index) {
            // this.$nextTick(() => {
            if (this.fieldset2[index] == true) {

                this.check_attend[index] = e.target.id;
                this.attendance_status = e.target.id
            } else {
                this.check_attend[index] = 0;
                this.attendance_status = 0
            }

            // console.log(this.check_attend, e.target.id)
            // })
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
                    this.staffs = data.staffs;
                    this.jobs = data.jobs;
                    this.qualifications = data.qualifications;
                    this.nationalities = data.nationalities;
                    this.religions = data.staff_religions;
                    this.staff_types = data.staff_types;
                    this.branches = data.branches;
                    this.departments = data.departments;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        Add_newattendance() {

            Add_new_for_staff(this)
            // Add_new_for_staff(this);
            // this.$router.go(0);

        },


    },
};
</script>
  
