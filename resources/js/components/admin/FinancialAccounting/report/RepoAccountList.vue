<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <form method="post" @submit.prevent="submitForm">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> كشف حساب </span>
            </div>
        
          </div>
          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2">
                    

                          <div class="d-flex justify-content-right">
             
              


              <input
                type="text"
                autocomplete="on"
                name="search"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="true"
                placeholder="ادخل رقم الحساب"
                v-model="account_id"
                @input="get_search()"
              />

            

              <div>
                
              </div>
              
            </div>
            
                    </div>
                       <div class="col-md-2">
                   

                    <a
                      href="javascript:void"
                      @click="account(account_id)"
                      data-toggle="modal"
                      id="agregar_productos"
                      data-target="#modal_refund"
                      class="tn btn-info btn-lg waves-effect btn-agregar"
                      ><span>بحث </span></a
                    >
                  </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">التاريخ</th>
                    <th class="wd-15p border-bottom-0">البيان</th>
                    <th class="wd-15p border-bottom-0">مدين</th>

                    <th class="wd-15p border-bottom-0">داين</th>
                    <th class="wd-15p border-bottom-0">الرصيد</th>
                  </tr>
                </thead>
                <tbody v-if="repoaccounts && repoaccounts.length > 0">
                  <tr
                    v-for="(account, index) in repoaccounts"
                    :key="index"
                  >
                <!-- <input type="hidden" name="" v-model="balance=account.debit+account.credit"> -->
                    <td>{{ account.daily_date }}</td>
                    <td>{{ account.description }}</td>
                    <td>{{ account.debit }}</td>
                    <td>{{ account.credit }}</td>
                    <td v-if="account.debit>account.credit">{{ (balance=balance+account.debit)}}</td>
                    <!-- <td v-else-if="account.debit>account.credit && balance<0">{{ (balance=balance+account.debit)}}</td>
                    <td v-else-if="account.debit>account.credit && balance>0">{{ (balance=account.debit+balance)}}</td> -->
                     
                    <!-- <td v-if=''>{{ (balance=account.credit-balance)}}</td> -->
                      <!-- <td v-if="account.debit<account.credit">{{ (balance=account.debit-balance)}}</td> -->
                       <td v-else-if="account.debit<account.credit && balance<account.credit">{{ (balance=account.credit-balance)}} </td>
                    <td v-else-if="account.debit<account.credit && balance>account.credit">{{ (balance=balance-account.credit)}} </td>
                  
                   
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="5">لايوجد بياتات.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div
              class="modal fade"
              id="exampleModalCenter"
              tabindex="-1"
              role="dialog"
              aria-labelledby="exampleModalCenterTitle"
              aria-hidden="true"
            >
              <div
                class="modal-dialog modal-dialog-centered"
                role="document"
                style="max-width: 500px"
              >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <ul style="list-style-type: none" v-for="tree in trees">
                      <li>
                        <a style="color: red" @click="account_list(tree.id)">{{
                          tree.account_name_ar
                        }}</a>
                      </li>
                      {{
                        n
                      }}
                      <div v-if="tree.child">
                        <subAccount
                          :child="tree.child"
                          :number="n"
                          @update-cart="repoaccounts = $event"
                        ></subAccount>
                      </div>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>
// import pagination from "laravel-vue-pagination";
// import SubAccount from "../accounting/SubAccount";
export default {
  components: {
    // pagination,
    // SubAccount,
  },

  data() {
    return {
      n: "",
      trees: "",
      repoaccounts: "",
      account_id:'',

      num:123456789,
      digits:0,
 
     
      data: {
        description: "",
        debit: "",
        credit: "",
        balance: "",
        daily_date: "",
      },
    };
  },
  mounted() {
    // this.list();

    
    this.num = this.num.toString(); 
    this.digits = this.num.split("");

    this.lenght = this.digits.length;


  },
  created() {
    this.axios.post("/tree_account").then((response) => {
      this.trees = response.data.accounts;
    });
  },
  methods: {
    account(id){
let uri = `/account_list/${id}`;
this.axios.post(uri).then((response) => {
        console.log(response.data.daily_details);
        this.repoaccounts = response.data.daily_details;

this.balance = 0;
        // if(this.balance<0){
       
        //    balance*j;
 
        // }
      });
    },
    // account_list(id) {
    //   // alert(id);
    //   let uri = `/account_list/${id}`;
    //   this.axios.get(uri).then((response) => {
    //     console.log(response.data.daily_details);
    //     // this.repoaccounts = response.data.daily_details;
    //   });
    // },
    add_row() {},
  },
};
</script>

