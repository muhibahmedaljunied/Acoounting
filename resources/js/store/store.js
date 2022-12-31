import { forEachRight } from "lodash"
export default {
  state: {
		categories: [],
    featuredProducts: [],
    newProducts: [],
    catProducts: [],
    singleProducts: [],
    cartProduct: [],
    countCart: [],
    subtotalCart: [],
    customerSession:[],
    productOrder:[],
    orderDetails:[],
    productReorder:[],
    customerReorderDetails:[],
    customerOrder:[],
    paymentOrder:[],
    purchaseDetails:[],
    productPurchase:[],
    supplierPurchase:[],
    productRepurchase:[],
    supplierRepurchase:[],
    // productComment:[]
  },

  getters: {
    getCategory(state){
  		return state.categories
  	},
    getfeaturedProduct(state){
      return state.featuredProducts
    },
    getNewProduct(state){
      return state.newProducts
    },
    getCatProduct(state){
      return state.catProducts
    },
    getSingleProduct(state){
      return state.singleProducts
    },
    getCartItem(state){
      return state.cartProduct
    },
    getCountCart(state){
      return state.countCart
    },
    getCartSubtotal(state){
      return state.subtotalCart
    },
    getOrderInformation(state){
      return state.orderDetails
    },
    getProductInformation(state){
      return state.productOrder
    },
    getProductReorderInformation(state){
      console.log(state.productReorder)
      return state.productReorder
    },
    getCustomerReorderInformation(state){
      return state.customerReorderDetails
    },
    getProductPurchaseRefundInformation(state){
    
      return state.productRepurchase
    },
    getSupplierPurchaseRefundInformation(state){
      return state.supplierRepurchase
    },
    getCustomerInformation(state){
      return state.customerOrder
    },
    getPurchaseInformation(state){

      return state.purchaseDetails
    },
    getProductpurInformation(state){
      return state.productPurchase
    },
    getSupplierInformation(state){

      return state.supplierPurchase
    },
    getSessionData(state){
      return state.customerSession
    },
    // getCommentData(state){
    //   return state.productComment
    // }
    getPaymentInformation(state){
      return state.paymentOrder
    },
  },
    

  actions: {
    category(context){
      axios.post('/category')
          .then((response) =>{
      
            context.commit("allCategory", response.data)
          })
    },
    featuredProduct(context){
      axios.post('/customer/featured-product')
          .then((response) =>{
     
            context.commit("featureProducts", response.data)
          })
    },
    newProduct(context){
      axios.post('/customer/new-product')
          .then((response) =>{

            context.commit("getNewProduct", response.data)
          })
    },
    categoryByID(context, payload){
      axios.post('/customer/category/'+ payload)
          .then((response) =>{
           
            context.commit("getProductbyId", response.data)
          })
    },
    getProducstbyId(context, payload){
      axios.post('/customer/product-details/'+ payload)
          .then((response) =>{

            context.commit("getSingleProduct", response.data)
          })
    },
    getCartItem(context){
      axios.post('/customer/all-cart')
          .then((response) =>{

            context.commit("allCartItem", response.data.cart)
          })
    },
    countCart(context){
      axios.post('/customer/all-cart')
          .then((response) =>{
            console.log(response.data)
            context.commit("countCartItem", response.data.count_cart)
          })
    },
    getAllCarttotal(context){
      axios.post('/customer/all-cart')
          .then((response) =>{
     
            context.commit("allCarttotal", response.data.subtotal)
          })
    },
    getOrderdetails(context,payload){
      axios.post('/order-details/'+ payload)
          .then((response) =>{
         
            context.commit("orderDetails", response.data)
          })
    },
    getPurchasedetails(context,payload){
      axios.post('/purchase-details/'+ payload)
          .then((response) =>{
       
           
            context.commit("purchaseDetails", response.data)
          })
    },
    productByorder(context,payload){
      axios.post('/product-order/'+ payload)
          .then((response) =>{
         
            context.commit("productByorder", response.data)
          })
    },
    productByreorder(context,payload){
      
      axios.post('/product-reorder/'+ payload)
          .then((response) =>{
            // alert(response.data.id);
  
            context.commit("productByreorder", response.data)
          })
    },
    getCustomerReorderdetails(context,payload){
      axios.post('/customer-reorder/'+ payload)
          .then((response) =>{
         
            context.commit("customerReorderDetails", response.data)
          })
    },
    productByPurchaseRefunded(context,payload){
      
      axios.post('/product-repurchase/'+ payload)
          .then((response) =>{
            // alert(response.data.id);
  
            context.commit("productByPurchaseRefunded", response.data)
          })
    },
    getSupplierPurchaseRefunded(context,payload){
      axios.post('/supplier-repurchase/'+ payload)
          .then((response) =>{
         
            context.commit("supplierPurchaseRefunded", response.data)
          })
    },
    customerByorder(context,payload){
      axios.post('/customer-order/'+ payload)
          .then((response) =>{
            context.commit("customerByorder", response.data)
          })
    },
    productBypurchase(context,payload){

      axios.post('/product-purchase/'+ payload)
          .then((response) =>{
           
            // console.log(response.data.cart)
            context.commit("productBypurchase", response.data)
          })
    },
    supplierBypurchase(context,payload){
      axios.post('/supplier-purchase/'+ payload)
          .then((response) =>{
          
            context.commit("supplierBypurchase", response.data)
          })
    },
    customerSession(context){
      axios.post('/customer/customer-session')
          .then((response)=>{
            context.commit("sessionData", response.data.s_customer)
          })
    },
    // getProductComment(context, payload){
    //   axios.get('/product-comment/'+ payload)
    //       .then((response)=>{
    //         //console.log(response.data)
    //         context.commit("commentData", response.data)
    //       })
    // }
     getPaymentdetails(context, payload){
      axios.post('/payment-details/'+ payload)
          .then((response)=>{
           
            context.commit("paymentDetails", response.data)
          })
    },
    getAllnewsale(context, payload){
      axios.post('/payment-details/'+ payload)
          .then((response)=>{
           
            context.commit("paymentDetails", response.data)
          })
    }

  },

	mutations: {
    allCategory(state, data){
      return state.categories = data
    },
    featureProducts(state, data){
      return state.featuredProducts = data
    },
    getNewProduct(state, data){
      return state.newProducts = data
    },
    getProductbyId(state, data){
      return state.catProducts = data
    },
    getSingleProduct(state, data){
      return state.singleProducts = data
    },
    allCartItem(state, data){
      return state.cartProduct = data
    },
    countCartItem(state, data){
      return state.countCart = data
    },
    allCarttotal(state, data){
      return state.subtotalCart = data
    },
    productByorder(state, data){
      return state.productOrder = data
    },
    orderDetails(state, data){
      return state.orderDetails = data
    },
    productByreorder(state, data){
      return state.productReorder = data
    },
    customerReorderDetails(state, data){
      return state.customerReorderDetails = data
    },
    
    customerByorder(state, data){
      return state.customerOrder = data
    },
    sessionData(state, data){
      return state.customerSession = data
    },
    paymentDetails(state, data){
     
      return state.paymentOrder = data
       
    },
    purchaseDetails(state, data){
   
      return state.purchaseDetails = data
    },
    productBypurchase(state, data){
      return state.productPurchase = data
    },
    supplierBypurchase(state, data){
      return state.supplierPurchase = data
    },
    productByPurchaseRefunded(state, data){
      return state.productRepurchase = data
    },
    supplierPurchaseRefunded(state, data){
      return state.supplierRepurchase = data
    },
    // commentData(state, data){
    //   return state.productComment = data
    // }
  }
}



