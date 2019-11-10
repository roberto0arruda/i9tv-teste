import axios from 'axios'

const api = axios.create({
  baseURL: 'http://i9tv-backend.test/api/'
})

export default api
