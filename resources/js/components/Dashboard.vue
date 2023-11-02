<template>
	<!-- row -->
	<div class="container-fluid">
		<div class="row row-sm">
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-primary-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">العملاء</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ order }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-up text-white"></i>
									<span class="text-white op-7"> +427</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-danger-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">الموردين</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ category }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-down text-white"></i>
									<span class="text-white op-7"> -23.09%</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-success-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">المخزون</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">$7,125.70</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-up text-white"></i>
									<span class="text-white op-7"> 52.09%</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-warning-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">الاصناف</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ product }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-down text-white"></i>
									<span class="text-white op-7"> -152.3</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row row-sm">
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-primary-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">المبيعات</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ order }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-up text-white"></i>
									<span class="text-white op-7"> +427</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-danger-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">المشتريات</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ category }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-down text-white"></i>
									<span class="text-white op-7"> -23.09%</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-success-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">المصروفات</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">$7,125.70</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-up text-white"></i>
									<span class="text-white op-7"> 52.09%</span>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="card-body">

					<form id="excel-csv-import-form" method="POST" accept-charset="utf-8" enctype="multipart/form-data">



						<div class="row">

							<div class="col-md-12">
								<div class="form-group">
									<input v-on:change="onFileChange" type="file" name="file" placeholder="Choose file">
								</div>

								<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>

							</div>

							<div class="col-md-12">
								<button type="button" @click="exports_excel" class="btn btn-primary"
									id="submit">export</button>
								<button @click="imports_excel()" type="button" class="btn btn-primary" id="submit2">import</button>
							</div>
						</div>
					</form>

				</div>

			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
				<div class="card overflow-hidden sales-card bg-warning-gradient">
					<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
						<div class="">
							<h6 class="mb-3 tx-12 text-white">PRODUCT</h6>
						</div>
						<div class="pb-0 mt-0">
							<div class="d-flex">
								<div class="">
									<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ product }}</h4>
									<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
								</div>
								<span class="float-right my-auto mr-auto">
									<i class="fas fa-arrow-circle-down text-white"></i>
									<span class="text-white op-7"> -152.3</span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- row closed -->
	<!-- </div>
		</div> -->
	<!-- Container closed -->
</template>

<script>
export default {
	data() {
		return {
			category: '',
			product: '',
			order: '',
			val: 'component',
			file: '',
		}
	},
	mounted() {
		this.axios.post(`/dashboard`).then(response => {
			this.category = response.data.category
			this.product = response.data.product
			this.order = response.data.order
			this.$root.logo = 'Dashboard'

		});


	},
	methods: {




		onFileChange(e) {
			this.file = e.target.files[0];
		},

		// exports_excel() {

		// 	axios
		// 		.post(`export`)
		// 		.then(function (response) {

		// 			// console.log(1);
		// 		})
		// 		.catch(error => {

		// 		});
		// },
		// imports_excel() {

		// 	axios
		// 		.post(`import`)
		// 		.then(function (response) {

		// 			// console.log(1);
		// 		})
		// 		.catch(error => {

		// 		});
		// },


	},

}
</script>