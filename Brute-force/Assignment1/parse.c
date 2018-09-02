#include <stdio.h>

int main() {
    
    char str[50] = "2 cars 3 dogs 4 trucks 1 cat";
    
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
    
    printf("Dogs = %d\nCats = %d\nCars = %d\nTrucks = %d\n",dog,cat,car,truck);
	
	return 0;
}
