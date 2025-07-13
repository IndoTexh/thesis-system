import { useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const ConfirmPass = () => {

  const { flash } = usePage().props;

  useEffect(() => {
    if(flash?.message) {
      toast.error(flash.message);
    }
  }, [flash]);

  const passwordForm = useForm({
    password: '',
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    passwordForm.post('/confirm-password');
  };

  return (
    <div className="max-w-xl mx-auto mt-5 space-y-6 bg-white p-6 rounded shadow">
      <p className='text-gray-400 font-medium mb-0'>Because of the page you're trying to access is the sensitive area, we need you to confirm your password before redirecting you there.</p>
      <p className='text-blue-600 font-medium text-sm mt-2'>Note: We do this for security purposes!</p>
      <Toaster position="top-center" />
      <h2 className="text-2xl font-bold text-blue-600 mb-4">Password Confirmation</h2>

      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label>Password</label>
          <input
            type="password"
            className="w-full border rounded p-2 mt-1"
            value={passwordForm.data.password}
            onChange={(e) => passwordForm.setData('password', e.target.value)}
          />
          {passwordForm.errors.password && <div className="text-red-500 text-sm">{passwordForm.errors.password}</div>}
        </div>

        <button
          disabled={passwordForm.processing}
          className="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          Confirm
        </button>
      </form>
    </div>
  );
};

export default ConfirmPass;
