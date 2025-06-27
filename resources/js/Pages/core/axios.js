import axios from 'axios'
import { setLoader } from './useLoader'
const instance = axios.create()

instance.interceptors.request.use((config) => {
  setLoader(true)
  return config
})

instance.interceptors.response.use(
  (response) => {
    setLoader(false)
    return response
  },
  (error) => {
    setLoader(false)
    return Promise.reject(error)
  }
)
export default instance