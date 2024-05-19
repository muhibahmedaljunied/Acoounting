export default {

    methods: {


        check_prouct(table,data,count= null) {

            if (this.type == 'Stock' || this.type == 'Movement') {

                this.productselected = data.node.id;
                this.productselectedname = data.node.text;
            }
            if (this.type == 'Opening') {

                this.product[this.indexselected] = data.node.id;
                this.product_tree(data,count)  //this for get units of product 
            }

            if (this.type == 'Purchase' || this.type == 'Supply') {

              
                this.product_tree(data,count)  //this for get units of product 
            }

       


            if (this.type == 'Cash') {

                this.get_product_for_cash(data.node.id, table);
            }

            if (this.type == 'Sale') {

                this.get_product_for_sale(data.node.id, table);
            }

            if (this.type == 'Transfer') {

                this.product_one = data.node.id;
                this.get_product_for_transfer('product', data.node.id);
            }

            if (this.type == 'Transfer') {


                gf.store_one = data.node.id;
                gf.fromstore = data.node.text;
                gf.fromstore_id = data.node.id;

                gf.get_product_for_transfer('store', data.node.id);


            }
        },
        productm_tree(data) {

   
            this.productm[this.indexselected] = data.node.id;
            console.log('data.node.id', data.node.id);
                axios.post(`/get_unit/${data.node.id}`).then((response) => {
                    this.units = response.data.units;
              
                  

                         
                            this.units = response.data.units;

                            var arrayLength = response.data.units.length
                            var html = '';


                            for (var i = 0; i < arrayLength; i++) {
                                // console.log('muhib', this.units[i].name);

                                html = html + `<option data-rate-${this.indexselected} = ${this.units[i].rate} data-${this.indexselected} = ${this.units[i].unit_type}  value=[${this.units[i].id},${this.units[i].rate},${this.units[i].unit_type}]>${this.units[i].name}</option>`;

                            }
                            // console.log(html);
                            $(`#select_unit${this.indexselected}`).html(html);


                            $(`#${this.type}_productm_tree${this.indexselected}`).val(data.node.text);

                        


                });

            

        },
        product_tree(data, count = null) {





            this.product = data.node.id;
            axios.post(`/get_unit/${data.node.id}`).then((response) => {
         
            var ds = 0;
            for (const key in count) {

                ds = count[key];
                this.units = response.data.units;

                var arrayLength = response.data.units.length
                var html = '';


                for (var i = 0; i < arrayLength; i++) {
                    console.log('muhib', this.units[i].name);

                    html = html + `<option data-rate-${ds} = ${this.units[i].rate} data-${ds} = ${this.units[i].unit_type}  value=[${this.units[i].id},${this.units[i].rate},${this.units[i].unit_type}]>${this.units[i].name}</option>`;

                }
                $(`#select_unit${ds}`).html(html);


                $(`#${this.type}_productm_tree${ds}`).val(data.node.text);
                this.productm[ds] = data.node.id;

            }

            });


        },
        

        get_product_for_sale(id, table) {
            axios.post(`/sale/newsale/${id}`, { type: table }).then((responce) => {

                this.all_products = responce.data.products.data;

            });
        },



        get_product_for_cash(id, table) {
            axios.post(`/cash/newcash/${id}`, { type: table }).then((responce) => {

                this.all_products = responce.data.products.data;

            });
        },

        get_product_for_transfer(type, id) {


            let uri = `/get_product`;
            axios
                .post(uri, { id: id, type: type })
                .then((responce) => {
                    this.detail = responce.data.products;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },




    }
};


