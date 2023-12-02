use core::panic;
use std::{
    fs::File,
    io::{BufReader, Read},
};

fn main() {
    let content = match File::open("input/input.txt") {
        Ok(file) => file,
        Err(error) => panic!("Problem opening the file: {:?}", error),
    };

    let mut reader = BufReader::new(content);
    let mut raw_calibration_value = String::new();
    let mut num_bytes = match reader.read_to_string(&mut raw_calibration_value) {
        Ok(readed_line) => readed_line,
        Err(error) => panic!("Reading from cursor won't fail: {:?}", error),
    };

    while num_bytes > 0 {
        println!("{}", raw_calibration_value);

        raw_calibration_value.clear();
        num_bytes = match reader.read_to_string(&mut raw_calibration_value) {
            Ok(readed_line) => readed_line,
            Err(error) => panic!("Reading from cursor won't fail: {:?}", error),
        };
    }
}
