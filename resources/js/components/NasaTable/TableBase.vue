<template>
    <table class="table table:border secondary-5:border">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Date</th>
            <th scope="col">Coordinates</th>
            <th scope="col">Category</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="td in tableData">
            <th scope="row">{{td.id}}</th>
            <td>{{td.title}}</td>
            <td>{{td.date}}</td>
            <td>
                <img class="earth-img" src="img/planet-earth.png" width="20">
                <a class="coords-link" :href="td.coordinates">Show in Google Maps</a>
            </td>
            <td>{{td.category}}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
  name: "TableBase",
  props:{
      entries: [],
      categories: []
  },
  computed: {
      tableData(){
          this.entries.map(event => {
              if(this.categories.length !== 0) {
                  event.category = this.categories.find(category => {
                      return category.id === event.category_id
                  }).title;
              }
          });
          return this.entries || [];
      }
  },

  methods: {

  }
}
</script>

<style scoped>
    .coords-link{
        color: #183148;
        font-weight: bolder;
        text-decoration: none;
        border-bottom: 1px dotted #183148;
        transition: all 0.5s ease;
    }
    .coords-link:hover{
        color: #184f9b;
    }
</style>
