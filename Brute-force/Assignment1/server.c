/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <stdlib.h>
#define _GNU_SOURCE         /* See feature_test_macros(7) */
#include <unistd.h>
#include <sys/syscall.h>

// void sendImages(int dog,int cat,int car,int truck,int newSocket){
//      printf("hii \n");
//      int size;
//      char fileName[20];
//      sprintf(fileName,"images/dog%d.jpeg",4);
//      send(newSocket,"newfile/1.jpeg",1024,0);
//     FILE* file = fopen(fileName, "rb");
//     // char *s;
//     fseek(file,0,SEEK_END);
//     size = ftell(file);
//     send(newSocket,&size,sizeof(int),0);       // size of image
//     printf("size is %d \n",size);
//     printf("ok start\n");
//     int sent_size =0,stat,packet_index=1;
//     char send_buffer[10240], read_buffer[256];
//      packet_index = 1;
//     // send(newSocket,file,size+1,0);
//     // printf("%s\n",file);
//       while(!feof(file)) {
//    //while(packet_index = 1){
//       //Read from the file into our send buffer
//       read_size = fread(send_buffer, 1, sizeof(send_buffer)-1, picture);

//       //Send data through our socket 
//       do{
//         stat = write(socket, send_buffer, read_size);  
//       }while (stat < 0);

//       printf("Packet Number: %i\n",packet_index);
//       printf("Packet Size Sent: %i\n",read_size);     
//       printf(" \n");
//       printf(" \n");


//       packet_index++;  

//       //Zero out our send buffer
//       bzero(send_buffer, sizeof(send_buffer));
//      }

//     printf("end done\n");


//}


  int send_image(int socket,char *fileName){

   FILE *picture;
   int size, read_size, stat, packet_index;
   char send_buffer[10240], read_buffer[256];
   packet_index = 1;

    printf("Sending Picture name\n");
    write(socket,fileName,1024);

   picture = fopen(fileName, "r");
   printf("Getting Picture Size\n");

   fseek(picture, 0, SEEK_END);
   size = ftell(picture);
   fseek(picture, 0, SEEK_SET);
   printf("Total Picture size: %i\n",size);

   //Send Picture Size
   printf("Sending Picture Size\n");
   write(socket, (void *)&size, sizeof(int));

   //Send Picture as Byte Array
   printf("Sending Picture as Byte Array\n");

   while(!feof(picture)) {
   //while(packet_index = 1){
      //Read from the file into our send buffer
      read_size = fread(send_buffer, 1, sizeof(send_buffer)-1, picture);

      //Send data through our socket 
      do{
        stat = write(socket, send_buffer, read_size);
      }while (stat < 0);

      printf("Packet Number: %i\n",packet_index);
      printf("Packet Size Sent: %i\n",read_size);
      printf(" \n");
      printf(" \n");


      packet_index++;

      //Zero out our send buffer
      bzero(send_buffer, sizeof(send_buffer));
     }
   }

void ExtractObj(char *str,int newSocket){
        int i =0,count,dog=0,cat=0,car=0,truck=0;
    char ch, name[2];
    while( str[i] != '\0'){
        ch = str[i];

        if (ch > '0' &&  ch < '5'){
            count = ch - 48;

            i++;
            name[0] = str[++i];
            i++;
            name[1] = str[++i];

            if(name[0] == 'd')             //dog
                dog = count;
            else if(name[0] == 't')        //truck
                truck = count;
            else if(name[1] == 't')        //cat
                cat = count;
            else                             //car
                car = count;
        }

        i++;
    }
int cnt = dog + cat + car + truck;
    printf("sendind count : %d\n",cnt );
    send(newSocket,(void*)&cnt,sizeof(int),0);
    FILE *fd = fopen("/var/www/html/input.txt", "w");
    fprintf(fd, "%d%d%d%d\n",dog,cat,car,truck);
    fclose(fd);
    char fname[32];
    while(dog>0){
        sprintf(fname, "images/dog%d.jpg",dog);
        send_image(newSocket,fname);
        char tmp[1024];
        recv(newSocket,tmp,1024,0);
        dog--;
    }
    while(cat>0){
        sprintf(fname, "images/cat%d.jpg",cat);
        send_image(newSocket,fname);
        char tmp[1024];
        recv(newSocket,tmp,1024,0);
        cat--;
    }
    while(car>0){
        sprintf(fname, "images/car%d.jpg",car);
        send_image(newSocket,fname);
        char tmp[1024];
        recv(newSocket,tmp,1024,0);
        car--;
    }
    while(truck>0){
        sprintf(fname, "images/truck%d.jpg",truck);
        send_image(newSocket,fname);
        char tmp[1024];
  recv(newSocket,tmp,1024,0);
        truck--;
    }
    // system("rm index.html")
    system("wget -O index.html localhost:80 --no-check-certificate");
    send_image(newSocket,"index.html");

    printf("Dogs = %d\nCats = %d\nCars = %d\nTrucks = %d\n",dog,cat,car,truck);
        return;
}

int main(){
  int welcomeSocket, newSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  struct sockaddr_storage serverStorage;
  socklen_t addr_size;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  welcomeSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("172.17.0.2");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Bind the address struct to the socket ----*/
  bind(welcomeSocket, (struct sockaddr *) &serverAddr, sizeof(serverAddr));

  /*---- Listen on the socket, with 5 max connection requests queued ----*/
  if(listen(welcomeSocket,5)==0)
    printf("I'm listening\n");
  else
    printf("Error\n");

  /*---- Accept call creates a new socket for the incoming connection ----*/
  addr_size = sizeof serverStorage;
  newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);

  /*---- Send message to the socket of the incoming connection ----*/
while(1){
    if(recv(newSocket,buffer, 1024, 0)){
        printf("hiiiiiii\n");
      // if(strncmp(buffer,"ok",2)==0){
        ExtractObj(buffer,newSocket);
      // }
      // else if(strncmp(buffer,"wget",4)==0){
        // send(newSocket,"wait reading file....\n",22,0);
        // char *fileName="index.html";
        // printf("ok working..\n");
        // FILE* file = fopen(fileName, "r");
        // char *s;
        // while ((s = readline(file, 0)) != NULL)
        // {
        //     // puts(s);
        //     send(newSocket,s,1024,0);
        //     free(s);
        //     // printf("\n");
        // }
        // send(newSocket,"done..",4,0);
      // }
      // else if(strncmp(buffer,"chrome",6)==0){
      //   // send(newSocket,"wait opening file in google chrome..\n",100,0);
      //   char cmd[]="google-chrome file:///home/kamlesh/cs252/assign3/index.html";
      //   // system(cmd);
      //   send(newSocket,cmd,1024,0);
      // }
      // else if(strncmp(buffer,"exit",4)==0){
      //        send(newSocket,"return",13,0);
      // }
      // else{
      //   printf("Data received from client: %s\n",buffer);
      //   toUpper(buffer);
      //   // strcpy(buffer,"Hello World\n");
      //   send(newSocket,buffer,13,0);
      // }
  }


  }


  return 0;
}



                                                                                   49,1          Top
