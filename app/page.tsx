import Image from "next/image";

export default function Home() {
  return (
    <div className="flex p-2 justify-center border-b border-gray-200">
      {/*--------------Big div wrapper--------DOIT ETRE CHANGE EN CLIENT SIDE RENDERER POUR OPTION ET SEARCHBAR-------------------------- */}
      <Image
        src={"/images/gromuse.png"}
        alt="logo"
        height={100}
        width={180}
        className="inline"
      />
      <div className="w-[42%] h-full py-0  border rounded-r-xl border-gray-300  ml-15 flex">
        {/*----------------------------------------------------------searchbar div------------------------------------------------ */}
        <span className="border-r  p-2 rounded-l-3xl border w-45 h-full border-gray-900">
          <Image
            src={"pin.svg"}
            height={20}
            width={15}
            alt="pin"
            className="inline"
          />
          <span>Your location</span>
        </span>
        <span className="w-[87%]">
          <input
            placeholder="search products..."
            className="p-2 h-full w-full outline-none flex-1 border-none"
          ></input>
        </span>
        <span className="bg-primaryg h-full w-15  p-2">
          <Image
            src={"search.svg"}
            height={20}
            width={30}
            alt="pin"
            className="inline "
          />
        </span>
      </div>
      <div className="px-4 py-3 ml-2">
        {/*-----------------------------------------------------SIDE THINGS --------------------------------------------------*/}
        <span>
          <span className="p-1">
            <Image
              src={"cart.svg"}
              height={15}
              width={26}
              alt="pin"
              className="inline"
            />
          </span>
          <span className="relative">
            Cart
            <span className="absolute text-xs mb-4 p-1 bg-secondaryg rounded-full flex -top-2 -right-3.5 text-white justify-center items-center w-4 h-4 ">
              1
            </span>
          </span>
        </span>
        <span className="ml-3">
          <span className="p-1">
            <Image
              src={"person.svg"}
              height={15}
              width={26}
              alt="pin"
              className="inline"
            />
          </span>
          <span>My Account</span>
        </span>
      </div>
    </div>
  );
}
