import http from "../plugins/axios";
class usuarios {
  getAll() {
    return http.get("/lista");
  }
  getID(id){
    return http.get(`/get/${id}`);
  }
  create(data) {
    return http.post("/add", data);
  }
  update(id, data) {
    return http.post(`/update/${id}`, data);
  }
  delete(id) {
    return http.delete(`/delete/${id}`);
  }
}
export default new usuarios();