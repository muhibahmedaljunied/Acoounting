import tree_product from './tree_product.js';
import tree_account from './tree_account.js';
export default {

    mixins: [tree_account, tree_product],
    methods: {

        showtree(table, uri) {


            let gf = this;
            var id = `treeview_json_${table}`;

            this.axios.post(`/${uri}`).then((response) => {

                this.jsonTreeData = response.data.trees;

                if (this.type_of_tree == 0) { // this if tree is in the orignal screen (account,product,store,structure) 

                    this.last_nodes = response.data.last_nodes;
                    $(`#${table}_number`).val(response.data.last_nodes + 1);
                }






                $(`#${id}`).jstree({
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


                    // console.log('tree_account', gf.type, table,gf.indexselected);

                    if (gf.indexselected) {

                        $(`#${gf.type}_${table}_tree${gf.indexselected}`).val(data.node.id + ' ' + data.node.text);
                        $(`#${gf.type}_${table}_tree_id${gf.indexselected}`).val(data.node.id);

                        if (uri == 'tree_account') {

                            gf.account[gf.indexselected] = data.node.id;

                        }




                    } else {

                        $(`#${gf.type}_${table}_tree`).val(data.node.text);
                        $(`#${gf.type}_${table}_tree_id`).val(data.node.id);

                        if (table == 'account') {

                            gf.account = data.node.id;
                        }
                    }


                    if (table == 'expence' && gf.type == 'Expence') {
                        gf.expence[gf.indexselected] = data.node.id;
                    }


                    if (table == 'structure' && gf.type == 'Structure') {


                        gf.structureselected = data.node.id;
                        gf.structureselectedname = data.node.text;
                        gf.get_job(gf.structureselected)


                    }



                    // ----------------------------------------product-----------------------------------------------------------



                    if (table == 'account') {

                        gf.check_account(table, data);
                        // if (gf.type == 'Sale' || gf.type == 'Purchase' || gf.type == 'Supply' || gf.type == 'Cash') {

                        //     gf.group_accounts_details(gf, data.node.id)
                        // }


                    }
                    if (table == 'product') {

                        gf.check_prouct(table, data);
                        // if (gf.type == 'Stock' || gf.type == 'Movement') {

                        //     gf.productselected = data.node.id;
                        //     gf.productselectedname = data.node.text;
                        // }
                        // if (gf.type == 'Purchase' || gf.type == 'Supply' || gf.type == 'Opening') {

                        //     gf.product_tree(gf, data, table)  //this for get units of product 
                        // }

                        // if (gf.type == 'Cash') {

                        //     gf.get_product_for_cash(gf, data.node.id, table);
                        // }

                        // if (gf.type == 'Sale') {

                        //     gf.get_product_for_sale(gf, data.node.id, table);
                        // }

                        // if (gf.type == 'Transfer') {

                        //     gf.product_one = data.node.id;
                        //     gf.get_product_for_transfer(gf, 'product', data.node.id);
                        // }
                    }

                    if (table == 'store') {

                        gf.store = data.node.id;

                        if (gf.type == 'Sale') {

                            gf.get_product_for_sale(gf, data.node.id, table);
                            gf.get_account_for_store(gf);

                        }
                        if (gf.type == 'Cash') {

                            gf.get_product_for_cash(data.node.id, table);
                            gf.get_account_for_store();

                        }
                        if (gf.type == 'Transfer') {


                            gf.store_one = data.node.id;
                            gf.fromstore = data.node.text;
                            gf.fromstore_id = data.node.id;

                            gf.get_product_for_transfer('store', data.node.id);


                        }

                        // if (gf.type == 'Purchase' || gf.type == 'Supply') {

                        //     gf.store = data.node.id;
                        //     gf.get_account_for_store(gf);
                        // }

                        if (gf.type == 'Opening') {


                            gf.store[gf.indexselected] = data.node.id;

                        }


                        if (gf.type == 'Stock') {



                            gf.storeselected = data.node.id;
                            gf.storeselectedname = data.node.text;


                        }

                        if (gf.type == 'Movement') {


                            gf.storeselected = data.node.id;
                            gf.storeselectedname = data.node.text;

                        }




                        // gf.get_account_for_store(gf);

                    }
                    // if (table == 'storem') {

                    //     gf.storem[gf.indexselected] = data.node.id;


                    //     if (gf.type == 'Purchase' || gf.type == 'Supply') {

                    //         gf.storem[gf.indexselected] = data.node.id;
                    //         gf.get_account_for_storem(gf);
                    //     }


                    // }

                    if (table == 'intostore' && gf.type == 'Transfer') {


                        gf.intostore = data.node.text;
                        gf.intostore_id = data.node.id;


                    }







                });

            });
        },

        detect_index(index) {

            this.indexselected = index;
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
            // formData.append("account", this.account);
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


