
export default {

    methods: {

        showtree(table) {

            var uri = `/tree_${table}`;
            if(table == 'intostore'){

                uri = `/tree_store`;
            }

            if(table == 'expence' || table == 'payment'){

                uri = `/tree_account`;
            }

            let gf = this;


           
            this.axios.post(uri).then((response) => {
                //   this.trees = response.data.trees;

                if (this.type_of_tree == 1) {

                    this.jsonTreeData = response.data.trees;

                }

                console.log(this.jsonTreeData);
                if (this.type_of_tree == 0 && table == 'account' && gf.type == 'Store') {

                    this.jsonTreeData = response.data.trees;

                }


                if (this.type_of_tree == 0) { // this if tree is in the orignal screen (account,product,store,structure) 

                    this.jsonTreeData = response.data.trees;
                    this.last_nodes = response.data.last_nodes;
                    $(`#${table}_number`).val(response.data.last_nodes + 1);
                } 






                $(`#treeview_json_${table}`).jstree({
                    core: {
                        themes: {
                            responsive: false,
                        },
                        // so that create works
                        check_callback: true,
                        data: this.jsonTreeData,
                    },
                    types: {
                        default: {
                            icon: "fa fa-folder text-primary",
                        },
                        file: {
                            icon: "fa fa-file  text-primary",
                        },
                    },
                    checkbox: {
                        three_state: false,

                    },
                    state: {
                        key: "demo2"
                    },
                    search: {
                        case_insensitive: true,
                        show_only_matches: true
                    },
                    plugins: ["checkbox",
                        "contextmenu",
                        "dnd",
                        "massload",
                        "search",
                        "sort",
                        "state",
                        "types",
                        "unique",
                        "wholerow",
                        "changed",
                        "conditionalselect"],
                    contextmenu: {
                        items: contextmenu
                    },






                }).on('rename_node.jstree', function (e, data) {
                    // let currentObj = this;
                    // const config = {
                    //     headers: {
                    //         "content-type": "multipart/form-data",
                    //     },
                    // };


                    // let formData = new FormData();
                    // formData.append("text", data.node.text);

                    // let url = `/${table}_rename_node/${data.node.id}`;
                    // axios.post(url, formData).then((response) => {

                    //     currentObj.success = response.data.success;
                    //     currentObj.filename = "";

                    // }).catch(function (error) {
                    //     currentObj.output = error;
                    // });
                }).on("changed.jstree", function (e, data) {


                    console.log(gf.type,table);

                    if (gf.indexselected) {

                        $(`#${gf.type}_${table}_tree${gf.indexselected}`).val(data.node.id+' '+data.node.text);
                        $(`#${gf.type}_${table}_tree_id${gf.indexselected}`).val(data.node.id);

                        if (table == 'account') {

                            gf.account[gf.indexselected] = data.node.id;

                        }




                    } else {
                       
                        $(`#${gf.type}_${table}_tree`).val(data.node.text);
                        $(`#${gf.type}_${table}_tree_id`).val(data.node.id);

                        if (table == 'account') {
                    
                            gf.account = data.node.id;
                        }
                    }





                    if (table == 'structure' && gf.type == 'Structure') {


                        gf.structureselected = data.node.id;
                        gf.structureselectedname = data.node.text;
                        gf.get_job(gf.structureselected)


                    }

                    // ----------------------------------------product-----------------------------------------------------------

                    if (table == 'product' && gf.type == 'Stock') {

                        gf.productselected = data.node.id;
                        gf.productselectedname = data.node.text;
                    }

                    if (table == 'product' && gf.type == 'Movement') {

                        gf.productselected = data.node.id;
                        gf.productselectedname = data.node.text;

                    }


                    if (table == 'product' && gf.type == 'Purchase') {


                        gf.product_tree(gf, data, table)  //this for get units of product

                    }
                    if (table == 'product' && gf.type == 'Opening') {

                        gf.product_tree(gf, data, table) //this for get units of product

                    }


                    if (table == 'product' && gf.type == 'Supply') {

                        gf.product_tree(gf, data, table) //this for get units of product

                    }


                    if (table == 'product' && gf.type == 'Sale') {

                        gf.get_product_for_sale(gf, data.node.id,table);

                    }


                 




                    if (table == 'product' && gf.type == 'Transfer') {

                        gf.product_one = data.node.id;
                        gf.get_product_for_transfer(gf, 'product',data.node.id);
                    }




                    // ----------------------------------------store-----------------------------------------------------------
                    if (table == 'store' && gf.type == 'Transfer') {


                        gf.store_one = data.node.id;
                        gf.fromstore = data.node.text;
                        gf.fromstore_id = data.node.id;

                        gf.get_product_for_transfer(gf, 'store',data.node.id);


                    }

                    if (table == 'store' && gf.type == 'Sale') {


                        gf.store = data.node.id;
                        gf.get_product_for_sale(gf, data.node.id,table);
                        gf.get_account_for_store(gf);
                    }

                    if (table == 'intostore' && gf.type == 'Transfer') {


                        gf.intostore = data.node.text;
                        gf.intostore_id = data.node.id;

                  



                    }



                    if (table == 'store' && gf.type == 'Movement') {


                        gf.storeselected = data.node.id;
                        gf.storeselectedname = data.node.text;

                    }


                    if (table == 'store' && gf.type == 'Purchase') {


                        gf.store = data.node.id;
                        gf.get_account_for_store(gf);


                    }


                    if (table == 'store' && gf.type == 'Opening') {


                        gf.store[gf.indexselected] = data.node.id;

                    }


                    if (table == 'store' && gf.type == 'Stock') {



                        gf.storeselected = data.node.id;
                        gf.storeselectedname = data.node.text;


                    }

                    if (table == 'store' && gf.type == 'Supply') {


                        gf.store[gf.indexselected] = data.node.id;

                    }





                });

            });
        },

        detect_index(index) {

            this.indexselected = index;
        },
     
    

        get_account_for_store(gf) {


            axios.post(`/get_account_store/${gf.store}`).then((response) => {

                var arrayLength = response.data.accounts.length
                var html = '';
                console.log('muhib', response.data.accounts);
                if (arrayLength == 0) {

                    $(`#select_account_${gf.type}`).html('');
                    return;
                }
                for (var i = 0; i < arrayLength; i++) {
                    // console.log('muhib', gf.response.data.accounts);

                    html = html + `<option 
                                            value=${response.data.accounts[i].id}>${response.data.accounts[i].text}  ${response.data.accounts[i].id}
                                    </option>`;

                }
                console.log(html);
                $(`#select_account_${gf.type}`).html(html);


            });

        },
        product_tree(gf, data, table) {

            gf.product[gf.indexselected] = data.node.id;


            axios.post(`/get_unit/${data.node.id}`).then((response) => {

                // console.log(response.data.units);
                gf.units = response.data.units;

                var arrayLength = response.data.units.length
                var html = '';


                for (var i = 0; i < arrayLength; i++) {
                    console.log('muhib', gf.units[i].name);

                    html = html + `<option data-rate-${gf.indexselected} = ${gf.units[i].rate} data-${this.indexselected} = ${gf.units[i].unit_type}  value=[${gf.units[i].id},${gf.units[i].rate},${gf.units[i].unit_type}]>${gf.units[i].name}</option>`;

                }
                console.log(html);
                $(`#select_unit${gf.indexselected}`).html(html);


            });


        },

        get_job(id) {

            axios.post(`/staff/get_job/${id}`).then((response) => {


                var arrayLength = response.data.jobs.length
                var html = '';


                for (var i = 0; i < arrayLength; i++) {
                    console.log('muhib_job', response.data.jobs[i].text);

                    html = html + `<option data-period-${id}= ${response.data.jobs[i].id}   value= ${response.data.jobs[i].id} >${response.data.jobs[i].text}</option>`

                }
                $(`#select_structure`).html(html);


            });



        },

        get_product_for_sale(gf, id,table) {
            axios.post(`/sale/newsale/${id}`, { type: table }).then((responce) => {

                gf.all_products = responce.data.products.data;

            });
        },
        // get_store_for_sale(gf, id) {
        //     axios.post(`/sale/newsale/${id}`, { type: 'store' }).then((responce) => {

        //         gf.all_products = responce.data.products.data;

        //     });
        // },
        get_product_for_transfer(gf, type,id) {

          
            let uri = `/get_product`;
            axios
                .post(uri, { id: id, type: type })
                .then((responce) => {
                    gf.detail = responce.data.products;

                    // this.stores = responce.data.stores;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        addnode() {





            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data

            let formData = new FormData();
            formData.append(`${localStorage.getItem('table')}_id`, $(`#${localStorage.getItem('table')}_number`).val());
            formData.append("text", this.text);
            // formData.append(`${localStorage.getItem('table')}_name_en`, this.store_name_en);
            formData.append("parent", $("#parent").val());
            formData.append("account", this.account);
            formData.append("rank", $("#rank").val());
            formData.append("status", this.status);
            if (localStorage.getItem('table') == 'product') {
                // formData.append("status", this.status);
                formData.append("unit", this.unit);
                formData.append("purchase_price", this.purchase_price);
                formData.append("product_minimum", this.product_minimum);

                formData.append("purchase_price_for_retail_unit", this.purchase_price_for_retail_unit);
                formData.append("hash_rate", this.hash_rate);
                formData.append("retail_unit", this.retail_unit);
            }
            //  else {
            //     formData.append("status", this.status);

            // }

            axios
                .post(`store_${localStorage.getItem('table')}`, formData, config)
                .then(function (response) {
                    console.log(response);
                    currentObj.success = response.data.success;
                    currentObj.filename = "";

                    toastMessage("تم الاضافه بنجاح");
                    // console.log(1);
                })
                .catch(error => {
                    console.error(error)

                    this.error_text = error.response.data.error.text
                    this.error_hash_rate = error.response.data.error.hash_rate
                    this.error_purchase_price = error.response.data.error.purchase_price


                });



        },



    }
};


