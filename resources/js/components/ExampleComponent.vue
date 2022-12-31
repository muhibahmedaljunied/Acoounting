<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <!-- <div class="card-header">Example Component</div> -->

          <!-- <div class="card-body">I'm an example component.</div> -->

          <div class="container" style="padding: 10px 10px">
            <input type="text" id="text" name="name" value="" />

            <button @click="prints()">click</button>

            <div class="well" id="treeview_json"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  var jsonTreeData = [
    {
      id: "1",
      name: "Electronics",
      text: "Electronics",
      parent_id: "0",
      children: [
        {
          id: "2",
          name: "Mobile",
          text: "Mobile",
          parent_id: "1",
          children: [
            {
              id: "7",
              name: "Samsung",
              text: "Samsung",
              parent_id: "2",
              children: [],
           
            },
            {
              id: "8",
              name: "Apple",
              text: "Apple",
              parent_id: "2",
              children: [],
             
            },
          ],
        
        },
        {
          id: "3",
          name: "Laptop",
          text: "Laptop",
          parent_id: "1",
          children: [
            {
              id: "4",
              name: "Keyboard",
              text: "Keyboard",
              parent_id: "3",
              children: [],
           
            },
            {
              id: "5",
              name: "Computer Peripherals",
              text: "Computer Peripherals",
              parent_id: "3",
              children: [
                {
                  id: "6",
                  name: "Printers",
                  text: "Printers",
                  parent_id: "5",
                  children: [],
                
                },
                {
                  id: "10",
                  name: "Monitors",
                  text: "Monitors",
                  parent_id: "5",
                  children: [],
                
                },
              ],
          
            },
            {
              id: "11",
              name: "Dell",
              text: "Dell",
              parent_id: "3",
              children: [],
           
            },
          ],
       
        },
      ],
 
    },
  ];

  export default {
    data() {
      return {};
    },
    created() {
      //  this.prints();
    },
    mounted() {
      //  this.prints();
    },
    methods: {
      prints() {
        $("#treeview_json").jstree({
          core: {
            data: jsonTreeData,
          },
        });
      },
    },
  };
</script>




