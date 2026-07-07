import Image from "next/image";

export default function Navbar() {
  return (
    <div className="w-full h-12 bg-primaryg text-white text-sm ">
      <p className="pl-1 p-4 ml-[300px]">
        <Image
          src={"phone.svg"}
          width={20}
          height={20}
          alt="phone"
          className="inline fill-white"
        />
        <span>Customer Support: +51 (961) 004-181</span>
      </p>
    </div>
  );
}
