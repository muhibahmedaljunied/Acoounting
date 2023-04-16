
export default {

    data() {
        return {
            all_products: '',
            jsonTreeData: '',
            type_of_tree: 1,
            indexselected: '',
            indexselectedproduct: '',
            indexselectedstore: '',
            last_nodes: '',
            rank: 1,
            parent: 0,
            index: 0,


            statusselected: 0,
            unitselected: 0,
            unitselectedname: '',
            productselected: 0,
            productselectedname: "",
            storeselectedname: "",
            storeselected: 0,
            descselected: "",
            operationselected: 0,
            dateselected: 0,
            typeselected: [],
            checkselected: '',
            moveselected: 0,
            // moveselected: [],
        }
    },
    methods: {

        detect_index(index) {

            // alert(index);
            this.indexselectedproduct = index;
        },
        detect_index_store(index) {

            this.indexselectedstore = index;
        },
        showtree(table) {


            let gf = this;

            this.axios.post(`/tree_${table}`).then((response) => {
                //   this.trees = response.data.trees;

                if (table == 'product' && this.type_of_tree == 1) {

                    this.jsonTreeData = response.data.trees;

                }
                if (table == 'store' && this.type_of_tree == 1) {

                    this.jsonTreeData = response.data.trees;

                }
                if (table == 'structure' && this.type_of_tree == 1) {

                    this.jsonTreeData = response.data.trees;

                }

                if (this.type_of_tree == 0) {
                    console.log(response.data.trees);
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


                    $(`#${gf.type}_${table}_tree${gf.indexselectedproduct}`).val(data.node.text);
                    $(`#${gf.type}_${table}_tree_id${gf.indexselectedproduct}`).val(data.node.id);


                    if (table == 'structure' && gf.type == 'Structure') {
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstructure}`).val(data.node.text)
                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstructure}`).val(data.node.id);
                        gf.structureselected = data.node.id;
                        gf.structureselectedname = data.node.text;
                        gf.get_job(gf.structureselected)


                    }


                    // if (table == 'job' && gf.type == 'Structure') {

                    //     $(`#${gf.type}_${table}_tree${gf.indexselectedjob}`).val(data.node.text)
                    //     $(`#${gf.type}_${table}_tree_id${gf.indexselectedjob}`).val(data.node.id);
                    //     gf.jobselected = data.node.id;
                    //     gf.jobselectedname = data.node.text;
                    // }

                    if (table == 'product' && gf.type == 'Stock') {

                        gf.productselected = data.node.id;
                        gf.productselectedname = data.node.text;
                    }

                    if (table == 'product' && gf.type == 'Movement') {

                        gf.productselected = data.node.id;
                        gf.productselectedname = data.node.text;

                    }




                    if (table == 'product' && gf.type == 'Purchase') {

                        gf.product_tree(gf, data, table)

                    }
                    if (table == 'product' && gf.type == 'Opening') {

                        gf.product_tree(gf, data, table)

                    }


                    if (table == 'product' && gf.type == 'Supply') {

                        gf.product_tree(gf, data, table)

                    }

                    if (table == 'store' && gf.type == 'Supply') {

                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.store[gf.indexselectedstore] = data.node.id;

                    }

                    if (table == 'store' && gf.type == 'Opening') {

                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.store[gf.indexselectedstore] = data.node.id;

                    }

                    if (table == 'store' && gf.type == 'Purchase') {

                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.store[gf.indexselectedstore] = data.node.id;


                    }
                    if (table == 'store' && gf.type == 'Stock') {


                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.storeselected = data.node.id;
                        gf.storeselectedname = data.node.text;


                    }
                    if (table == 'store' && gf.type == 'Movement') {


                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.storeselected = data.node.id;
                        gf.storeselectedname = data.node.text;

                    }



                    if (gf.type == 'Sale') {

                        gf.get_product_for_sale(gf, data.node.id);
                    }

                    if (gf.type == 'Cash') {

                        gf.get_product_for_sale(gf, data.node.id);
                    }




                    if (gf.type == 'Supplier' || gf.type == 'Customer') {


                        $(`#${gf.type}_${table}_tree_id${gf.indexselected}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselected}`).val(data.node.text);
                    }

                    if (table == 'product' && gf.type == 'Transfer') {

                        gf.get_product_for_transfer(gf, data.node.id);
                    }

                    if (table == 'store' && gf.type == 'Transfer') {


                        $(`#${gf.type}_${table}_tree_id${gf.indexselectedstore}`).val(data.node.id);
                        $(`#${gf.type}_${table}_tree${gf.indexselectedstore}`).val(data.node.text);
                        gf.intostore[gf.indexselectedstore] = data.node.id;
                        // gf.intostore[gf.indexselected] = $(`#store_tree${gf.indexselected}`).val(data.node.text);


                    }






                });

            });
        },

        product_tree(gf, data, table) {

            gf.product[gf.indexselectedproduct] = data.node.id;

            axios.post(`/get_unit/${data.node.id}`).then((response) => {

                gf.units = response.data.units;

                var arrayLength = response.data.units.length
                var html = '';


                for (var i = 0; i < arrayLength; i++) {
                    console.log('muhib', gf.units[i].name);

                    html = html + `<option data-rate-${gf.indexselectedproduct} = ${gf.units[i].rate} data-${this.indexselectedproduct} = ${gf.units[i].unit_type}  value=[${gf.units[i].id},${gf.units[i].rate},${gf.units[i].unit_type}]>${gf.units[i].name}</option>`;

                }
                console.log(html);
                $(`#select_unit${gf.indexselectedproduct}`).html(html);


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

        get_product_for_sale(gf, id) {
            axios.post(`/sale/newsale/${id}`).then((responce) => {

                gf.all_products = responce.data.products.data;

            });
        },
        get_product_for_transfer(gf, id) {
            let uri = `/get_product`;
            axios
                .post(uri, { product: id })
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


