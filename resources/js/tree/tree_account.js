export default {

    methods: {


        check_storem(data) {




            this.storem[this.indexselected] = data.node.id;
            // console.log('masa',data.node.id,this.storem[this.indexselected]);

            if (this.type == 'Purchase' || this.type == 'Supply' || this.type == 'SaleReturn') {

                this.get_account_for_storem(data.node.id);




            }
        },
        check_account(data) {

            // this.account = data.node.id;


            if (
                this.type == 'Sale' ||
                this.type == 'SaleReturn' ||
                this.type == 'Cash' ||
                this.type == 'CashReturn' ||
                this.type == 'Purchase' ||
                this.type == 'PurchaseReturn' ||
                this.type == 'Supply' ||
                this.type == 'SupplyReturn' ||
                this.type == 'ReceivableBond' ||
                this.type == 'PaymentBond'
            ) {

                this.group_accounts_details(data.node.id)
            }



            // if (this.type == 'Purchase' || this.type == 'Supply') {

            //     // this.store = data.node.id;
            //     this.group_accounts_details(data.node.id)
            //     // this.get_account_for_store();
            // }

            // if (this.type == 'PurchaseReturn') {

            //     this.group_accounts_details(data.node.id)
            //     // this.get_account_for_store();
            // }

        },
        get_account_for_store(length) {

            axios.post(`/get_account_store/${this.store}`).then((response) => {

                var arrayLength = response.data.accounts.length

                if (arrayLength == 0) {

                    $(`#select_account_${this.type}`).html('');
                    return;
                }

                $(`#select_account_${this.type}`).val(response.data.accounts[0].id);

                // -----------------------------------------------------------------------------------
                for (const key in length) {

                    if (length.hasOwnProperty.call(length, key)) {
                        let element = 0;
                        console.log(key, this.type);
                        if (this.type == 'Purchase') {

                            element = length[key];
                        }
                        if (this.type == 'Supply') {

                            element = length[key];
                        }
                        if (this.type == 'SaleReturn') {

                            element = key;
                        }


                        this.get_account_for_storem_by_store(element, response.data.accounts);
                    }
                }



            });








        },

        get_account_for_storem_by_store(index, response_id) {



            console.log('al3', response_id);
            $(`#${this.type}_storem_tree${index}`).val(response_id[0].text);


            this.storem[index] = this.store;
            // console.log($(`#select_account_${this.type}`).val());
            this.storem_account[index] = response_id[0].id;




        },
         get_account_for_storem(d) {



            // console.log('almuhib',this.storem[this.indexselected]);

            var uh = 0;
            
                axios.post(`/get_account_store/${this.storem[this.indexselected]}`).then(async (response) => {

                    var arrayLength = response.data.accounts.length
                    if (arrayLength == 0) {

                        return;
                    }

                    // uh = new Promise(function (resolve) {

                    //     resolve(response.data.accounts[0].id);
                    // });
                    uh = response.data.accounts[0].id;
                    this.storem_account[this.indexselected] =  uh;
                    
                });

           


                console.log('masa',this.indexselected,this.storem_account[this.indexselected]);

            

            // this.storem_account[this.indexselected] = await uh;
           


        },

        gr(h) {
            this.storem_account[this.indexselected] = h;
        },

        group_accounts_details(id) {

            // console.log(id);
            axios.post(`/get_group_accounts_details_details/${id}`).then((response) => {

                var arrayLength = response.data.result_data.length
                var html = '';
                if (arrayLength == 0) {

                    $(`#select_account_${this.type}`).html('');
                    $(`#select_account_${this.type}_group`).html('');
                    return;
                }
                for (var i = 0; i < arrayLength; i++) {

                    html = html + `<option 
                                            value=${response.data.result_data[i].id}>${response.data.result_data[i].name}
                                    </option>`;

                    if (response.data.group_type == 'supplier') {

                        this.supplier[0] = response.data.result_data[i].id;
                        this.supplier[1] = response.data.result_data[i].name;
                    }

                    if (response.data.group_type == 'customer') {

                        this.customer[0] = response.data.result_data[i].id;
                        this.customer[1] = response.data.result_data[i].name;
                    }

                    if (response.data.group_type == 'treasury') {

                        this.treasury[0] = response.data.result_data[i].id;
                        this.treasury[1] = response.data.result_data[i].name;
                    }


                    if (response.data.group_type == 'bank') {

                        this.bank[0] = response.data.result_data[i].id;
                        this.bank[1] = response.data.result_data[i].name;
                    }

                }
                // console.log('qw',html);
                $(`#select_account_${this.type}_group`).html(html);


            });

        },






    }
};


