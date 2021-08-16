import request from './config';

export function getOne(url) {
  return request.getRequest(url);
}

export function getAll(url) {
  return request.getRequest(url);
}

export function postOne(url, data) {
  return request.postRequest(url, data);
}

export function putOne(url, data) {
  return request.putRequest(url, data);
}

export function deleteOne(url) {
  return request.deleteRequest(url);
}
