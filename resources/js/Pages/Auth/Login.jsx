import { useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Login = () => {

  const { flash } = usePage().props;

const { data, setData, post, processing, errors } = useForm({
    email: '',
    password: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/login');
  };

  useEffect(() => {
    if (flash?.message) {
      toast.success(flash.message);
    }
  }, [flash]);

  /* useEffect(() => {
    if (errors?.email) {
      toast.error(errors.email, {
        duration: 3000,
      });
    }
  }, [errors]); */



  return (
    <div className="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
      <Toaster position='top-center' />
      <h2 className="text-2xl font-bold mb-4">Login</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label>Email</label>
          <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} className="w-full border rounded p-2" />
          {errors.email && <div className="text-red-500 text-sm">{errors.email}</div>}
        </div>
        <div>
          <label>Password</label>
          <input type="password" value={data.password} onChange={e => setData('password', e.target.value)} className="w-full border rounded p-2" />
        </div>
        <button type="submit" disabled={processing} className="disabled:bg-sky-300 disabled:cursor-wait bg-sky-600 text-white px-4 py-2 rounded">Login</button>
      </form>
    </div>
  );
};

export default Login;
