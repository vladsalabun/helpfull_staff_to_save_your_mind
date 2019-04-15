<?php

# HELPERS:
    ->get();
    ->first();
    ->latest('age');
    ->orderBy('age', 'desc');


# SELECT:
    DB::table('table')->where(
                    array(
                        array('user_id', \Auth::user()->id), 
                        array('id', $id)
                    )
                )
            ->orderBy('id','desc')
            ->paginate(10); 

     
# INSERT:
    $id = DB::table('table')->insertGetId(
                                array(
                                    'field' => $field, 
                                    'user_id' => Auth::id(), 
                                )
                            );
    
# DELETE:
    DB::table('table')->where(
                    array(
                        array('member_id', $request->member_id),
                        array('id', $request->id),
                    )
                )->delete();

                