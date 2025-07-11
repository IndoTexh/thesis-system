import { useForm } from "@inertiajs/react"

const Register = () => {
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'student'
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/register');
  }

  return (
    <div className="max-w-md mx-auto mt-5 p-6 bg-white rounded shadow">
      <h2 className="text-2xl font-bold mb-4">Register</h2>
      <form  onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label>Name</label>
          <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="w-full border rounded p-2" />
          {errors.name && <div className="text-red-500 text-sm">{errors.name}</div>}
        </div>
        <div>
          <label>Email</label>
          <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} className="w-full border rounded p-2" />
          {errors.email && <div className="text-red-500 text-sm">{errors.email}</div>}
        </div>
        <div>
          <label>Password</label>
          <input type="password" value={data.password} onChange={e => setData('password', e.target.value)} className="w-full border rounded p-2" />
          {errors.password && <div className="text-red-500 text-sm">{errors.password}</div>}
        </div>
        <div>
          <label>Confirm Password</label>
          <input type="password" value={data.password_confirmation} onChange={e => setData('password_confirmation', e.target.value)} className="w-full border rounded p-2" />
        </div>
        <div>
          <label>Role</label>
          <select className="w-full border rounded p-2">
            <option value="student">Student</option>
            <option value="supervisor">Supervisor</option>
          </select>
        </div>
        <button type="submit" disabled={processing} className=" disabled:bg-green-300 disabled:cursor-wait bg-green-600 text-white px-4 py-2 rounded">
          { processing ? "Processing" : "Register" }
        </button>
      </form>
    </div>
  )
}

export default Register
