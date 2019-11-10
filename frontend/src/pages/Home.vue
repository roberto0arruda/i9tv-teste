<template>
  <div class="hello">
    <h1>{{ title }}</h1>
    <h4>{{ msg }}</h4>
    <h5 v-if="error">{{ error }}</h5>
    <ul>
      <li v-for="(item, index) in asteroids" :key="index">
        <p>{{ item.name }}</p>
      </li>
    </ul>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  name: 'Home',
  data () {
    return {
      title: 'Vue.js frontend App',
      msg: 'Carregando dados',
      error: '',
      asteroids: []
    }
  },
  mounted () {
    api
      .get(`asteroids`)
      .then(response => {
        const { callback: status, contextWrites: { to: data } } = response.data
        if (status === 'success') {
          const { near_earth_objects: nearEarthObjects, page: { total_elements: totalElements } } = data
          this.changeMsg('Objetos em volta da terra: ' + totalElements)
          this.asteroids = nearEarthObjects
        } else {
          const { status_code: sttsCode, status_msg: { error: { code, message } } } = data
          this.changeMsg(`${sttsCode} | ${code}`)
          this.error = message
        }
      })
  },
  methods: {
    changeMsg (newMsg) {
      this.msg = newMsg
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1,
h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
