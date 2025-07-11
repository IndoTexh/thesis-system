import { usePage } from "@inertiajs/react"
import { useEffect } from "react"
import toast, { Toaster } from "react-hot-toast";
const Dashboard = () => {

  const { flash } = usePage().props;

  useEffect(() => {
    if(flash?.message) {
      toast.success(flash.message);
    }
  }, [flash])
  
  return (
    <>
    <Toaster position="top-center"/>
    <h1>Dashboard</h1>
    </>
  )
}

export default Dashboard
