<template>
  <div>
    <div class="jumbotron row justify-content-center">
      <h1>{{ title }}</h1>
      <h2>{{counterText}}</h2>
    </div>
    <div v-if="allUsers && movementStatistics">
      <h2>Statistics</h2>
      <GChart
        type="LineChart"
        :data="lineChartUsersOverTime.chartData"
        :options="lineChartUsersOverTime.chartOptions"
      />
      <GChart
        type="PieChart"
        :data="pieChartMovementCategories.chartData"
        :options="pieChartMovementCategories.chartOptions"
      />
      <div>
          <table>
              <thead>
                  <tr>
       <th> Total Movements: {{ movementStatistics.total }}</th>
        
        <th>Expenses: {{ movementStatistics.totalExpenses }}% </th>
        <th>Incomes: {{ movementStatistics.totalTransfers }}% </th>
        <th>Transfers: {{ movementStatistics.totalTransfers }}%</th>
        <th>NonTransfers: {{ movementStatistics.totalNonTransfers }}%</th>
        
        <th>Smallest Movement: {{ movementStatistics.smallestMovement }} €</th>
        <th>Largest Movement: {{ movementStatistics.largestMovement }} €</th>
        <th>Average Movement: {{ movementStatistics.averageMovementValue }} €</th>
                  </tr>
              </thead>
          </table>
      </div>
    </div>
  </div>
</template>

<script>
import { Line } from "vue-chartjs";
export default {
  extends: Line,
  data: () => {
    return {
      title: "Statistics",
      movementStatistics: null,
      allUsers: null, //Ordered by date of creation (by the controller)
      adminUsers: [],
      operatorUsers: [],
      normalUsers: [],
      activeUsers: [],
      inactiveUsers: [],
      counterText: null,
      lineChartUsersOverTime: {
        chartData: [],
        chartOptions: {
          title: "Users over time",
          curveType: "function",
          legend: { position: "bottom" }
        }
      },
      pieChartMovementCategories: {
        chartData: [],
        chartOptions: {
          title: "Categories of all movements",
          legend: { position: "bottom" },
          height: 700,
          width: 700
        }
      }
    };
  },
  methods: {
   getUsers: function(){
            axios.get('api/users')
                .then(response=>{this.users = response.data.data;});
        },
    
    updateChart(users) {
      var arrayDateCount = []; //Set as [dateOfUsers,'count']
      var i;
      for (i = 0; i < users.length; i++) {
        var date = Date.parse(users[i].created_at);
        var year = this.getDateYear(date);
        arrayDateCount.push({ year: year, users: i + 1 });
      }
      //console.log(arrayDateCount);
      this.lineChartUsersOverTime.chartData = [["Year", "Users"]];
      for (i = 0; i < arrayDateCount.length; i++) {
        this.lineChartUsersOverTime.chartData.push([
          arrayDateCount[i].year,
          arrayDateCount[i].users
        ]);
      }
    },
    getDateFormatted(date) {
      var d = new Date(date);
      var datestring =
        d.getDate() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getFullYear() +
        " " +
        d.getHours() +
        ":" +
        d.getMinutes();
      return datestring;
    },
    getDateYear(date) {
      var d = new Date(date);
      var datestring = d.getFullYear();
      return parseInt(datestring);
    },
    getMovementStatistics() {
      axios.get("api/movements/getAllUserMovements").then(response => {
        this.movementStatistics = response.data;
        //Update statistics info charts
        this.pieChartMovementCategories.chartData = [
          ["Category", "Total"]
        ];
        var i;
        for (
          i = 0;
          i < this.movementStatistics.totalByCategory.length;
          i++
        ) {
          this.pieChartMovementCategories.chartData.push([
            this.movementStatistics.totalByCategory[i].category.toUpperCase(),
            this.movementStatistics.totalByCategory[i].total
          ]);
        }
      });
    }
  },
  mounted() {
    if (!this.$store.state.user) {
      this.$router.push({ path: "/home" });
    }
    if (this.$store.state.user && this.$store.state.user.type != "a") {
      this.$router.push({ path: "/home" });
      return;
    }
   this.getUsers();
    this.getMovementStatistics();
  },
  watch: {
    allUsers() {
      this.updateChart(this.allUsers);
    }
  }
};
</script>

<style>
#btn {
  color: rgb(177, 57, 57);
}
</style>