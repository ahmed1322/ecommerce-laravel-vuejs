
import axios from "axios";

let BaseApi = axios.create({
  baseURL: "http://127.0.0.1:8000"
});

let Api = function() {
  let token = localStorage.getItem("access_token");

  if (token) {
    BaseApi.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  }

  return BaseApi;
};

export default Api;
