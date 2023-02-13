import axios from 'axios'

axios.defaults.baseURL = 'https://app.followearns.com/test/public'

axios.interceptors.request.use(config => {
  
  const token = localStorage.getItem('token')

  if (token !== null) {
    
    config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
  }
  return config
})

export default axios