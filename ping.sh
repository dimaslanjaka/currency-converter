if ! [ -x "$(command -v curl)" ]; then 
  echo 'Error: curl is not installed.' >&2
  apt install curl -y
  exit 1 
fi
while :
do
  curl -I --insecure --silent --header "Connection: keep-alive" "https://www.webmanajemen.com/"
done