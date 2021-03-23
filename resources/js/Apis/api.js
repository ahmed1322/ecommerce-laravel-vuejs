
import axios from "axios";

// let BaseApi = axios.create({
//   baseURL: "http://127.0.0.1:8000"
// });

axios.create({baseURL: "http://127.0.0.1:8000"});

let Api = function() {
  let token = localStorage.getItem("access_token");

  if (token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  }
};

export default Api;
