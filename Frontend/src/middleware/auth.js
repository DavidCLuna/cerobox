
export default function (to, from, next) {
  console.log(to.path)
  console.log(to.from)
  const token = localStorage.getItem('token');


  if (token == null || token == 'null') {
    console.log('si es null')
    next({
      path: '/admin'
    })
  } else {
    if (to.path === '/admin') {
      next({
        path: '/admin/dashboard'
      })
    } else {
      next()
    }
  }
}