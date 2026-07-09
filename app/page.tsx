import Image from "next/image";

export default function Home() {
  return (
    <div className="flex p-2 justify-center border-b border-gray-200">
      {/*Big div wrapper */}
      <Image
        src={"/images/gromuse.png"}
        alt="logo"
        height={100}
        width={180}
        className="inline"
      />
      <div className="w-[50%] h-12 bg-amber-200 border rounded-r-xl border-gray-300 ml-15">
        {/*searchbar div */}
        <span className="border-r rounded-l-3xl border w-full h-full border-gray-900">
          <Image
            src={"pin.svg"}
            height={20}
            width={15}
            alt="pin"
            className="inline"
          />
          <span>Your location</span>
        </span>
        <span className="">
          <span>
            <input
              placeholder="search products..."
              className="w-[77%] h-full border-none"
            ></input>
          </span>
          <span className="bg-primaryg bg-cover h-[50%] w-[50%]">
            <Image
              src={"search.svg"}
              height={20}
              width={25}
              alt="pin"
              className="inline bg-cover"
            />
          </span>
        </span>
      </div>
      <div className="px-4 py-3 ml-2">
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
            <span className="absolute text-sm mb-4 p-1 bg-secondaryg rounded-4xl w-4 h-4 text-white text-center ">
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
