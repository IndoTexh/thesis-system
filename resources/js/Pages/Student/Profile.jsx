import { useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Profile = () => {
  const { auth, flash, status } = usePage().props;


  const infoForm = useForm({
    name: auth.user.name,
    email: auth.user.email,
  });

  const passwordForm = useForm({
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
  });

  useEffect(() => {
    if (flash?.message && flash?.status == 400) {
      toast.error(flash.message);
    }
  }, [flash]);

  const handleInfoSubmit = (e) => {
    e.preventDefault();
    infoForm.post('/student/profile/update');
  };

  const handlePasswordSubmit = (e) => {
    e.preventDefault();
    passwordForm.post('/student/profile/update-password');
  };

  return (
    <div className="max-w-xl mx-auto mt-5 space-y-6 bg-white p-6 rounded shadow">
      <Toaster position="top-center" />
      <h2 className="text-2xl font-bold text-blue-600 mb-4">Profile Settings</h2>

      <form onSubmit={handleInfoSubmit} className="space-y-4">
        <div>
          <label>Name</label>
          <input
            type="text"
            className="w-full border rounded p-2 mt-1"
            value={infoForm.data.name}
            onChange={(e) => infoForm.setData('name', e.target.value)}
          />
          {infoForm.errors.name && <div className="text-red-500 text-sm">{infoForm.errors.name}</div>}
        </div>

        <div>
          <label>Email</label>
          <input
            type="email"
            className="w-full border rounded p-2 mt-1"
            value={infoForm.data.email}
            onChange={(e) => infoForm.setData('email', e.target.value)}
          />
          {infoForm.errors.email && <div className="text-red-500 text-sm">{infoForm.errors.email}</div>}
        </div>

        <button
          disabled={infoForm.processing}
          className="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          Update Info
        </button>
      </form>

      <form onSubmit={handlePasswordSubmit} className="space-y-4 pt-6 border-t">
        <h3 className="font-semibold text-lg text-gray-700">Change Password</h3>

        <div>
          <label>Current Password</label>
          <input
            type="password"
            className="w-full border rounded p-2 mt-1"
            value={passwordForm.data.current_password}
            onChange={(e) => passwordForm.setData('current_password', e.target.value)}
          />
          {passwordForm.errors.current_password && (
            <div className="text-red-500 text-sm">{passwordForm.errors.current_password}</div>
          )}
        </div>

        <div>
          <label>New Password</label>
          <input
            type="password"
            className="w-full border rounded p-2 mt-1"
            value={passwordForm.data.new_password}
            onChange={(e) => passwordForm.setData('new_password', e.target.value)}
          />
          {passwordForm.errors.new_password && (
            <div className="text-red-500 text-sm">{passwordForm.errors.new_password}</div>
          )}
        </div>

        <div>
          <label>Confirm New Password</label>
          <input
            type="password"
            className="w-full border rounded p-2 mt-1"
            value={passwordForm.data.new_password_confirmation}
            onChange={(e) => passwordForm.setData('new_password_confirmation', e.target.value)}
          />
        </div>

        <button
          disabled={passwordForm.processing}
          className="bg-green-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          Change Password
        </button>
      </form>
    </div>
  );
};

export default Profile;
