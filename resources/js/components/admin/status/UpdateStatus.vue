<template>
    	<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								<p class="tx-12 tx-gray-500 mb-2">Example of Valex Simple Table. <a href="">Learn more</a></p>
							</div>
							<div class="card-body">
                                 <div class="form">
                    <h3 class="text-center">تعديل</h3>
                    <form method="post" @submit.prevent="updatestore">

                     <input v-model ='store.id' type="hidden"  name="name" id="name">
                     <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="store.name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                />
              </div>
            
                    <button type="submit" class="btn btn-primary btn-lg ">تعديل</button>
                     <button   @click="$router.go(-1)" type="button" class="btn btn-primary btn-lg">تراجع</button>
                </form>
            </div>
								
							</div>
						</div>
					</div>
					<!--/div-->
				</div>
				<!-- /row -->
			
</template>
<script>
    export default {
        data(){
          return{
            store:{
                  id:'',
                  name:'',
               
                  }      
            }
        },
      created() {
            let uri = `/store/${this.$route.params.id }`;
            this.axios.post(uri).then(response => {
              console.log(response);
                this.store.id = response.data.store.id;
                this.store.name = response.data.store.code;
               
            });
        },
        methods:{
            updatestore(event){

            let uri = `/update_store/${this.$route.params.id}`;

             axios.post(uri,{code: this.store.name}).then(response => {
               console.log(response);
                    event.preventDefault();

                     toastMessage("تم التعديل بنجاح");
                      
            });

                    this.$router.go(-1);

           
           

            }
        }
    }
</script>