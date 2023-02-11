import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000'

axios.interceptors.request.use(config => {
  
  const token = localStorage.getItem('token')

  if (token !== null) {
    
    config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
  }
  return config
})

export default axios